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
        $this->cacheStorePath = file_exists('../var') ? '../var/cache/quotes.cache.json' : './var/cache/quotes.cache.json';
        $this->cacheStore = json_decode(file_get_contents($this->cacheStorePath), true);
    }

    public function findQuotesByAuthor(string $author, int $limit): array
    {
        $quotes = $this->get($author);

        if(!$quotes)
        {
            $quotes = $this->dataProvider->findQuotesByAuthor($author, $limit);

            if( $quotes )
            {
                $this->set($author, $quotes);
            }
        }

        return array_slice($quotes, 0, $limit);
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
