<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Quote;

use App\Domain\Quote\QuoteCache;
use App\Domain\Quote\QuoteRepository;

class InMemoryQuoteCache implements QuoteCache
{
    /**
     * @var QuoteRepository
     */
    private $dataProvider;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var $cacheStore
     */
    private $cacheStore;

    /**
     * @var $cacheStorePath
     */
    private $cacheStorePath;

    /**
     * InMemoryQuoteCache constructor.
     *
     * @param QuoteRepository $dataProvider
     * @param int $ttl
     */
    public function __construct(QuoteRepository $dataProvider, $ttl=3600)
    {
        $this->dataProvider = $dataProvider;
        $this->ttl = $ttl;
        $this->cacheStorePath = '../var/cache/quotes.cache.json';
        $this->cacheStore = json_decode(file_get_contents($this->cacheStorePath), true);
    }

    public function __call($methodName, $args): array
    {
        $quotes = $this->get($args[0]);

        if(!$quotes)
        {
            $quotes = call_user_func_array(array($this->dataProvider, $methodName), $args);

            if( $quotes )
            {
                $this->set($args[0], $quotes);
            }
        }

        return $quotes;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key): array
    {
        if(array_key_exists($key, $this->cacheStore) && time() <= $this->cacheStore[$key]['meta']['expired_at'])
        {
            return unserialize($this->cacheStore[$key]['data']);
        }
        else
        {
            return [];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $data)
    {
        $this->cacheStore[$key]['data'] = serialize($data);
        $this->cacheStore[$key]['meta'] = ['expired_at' => time() + $this->ttl];

        file_put_contents($this->cacheStorePath, json_encode($this->cacheStore));

    }


}
