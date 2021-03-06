<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Quote;

use App\Domain\Quote\Quote;
use App\Domain\Quote\QuoteNotFoundException;
use App\Domain\Quote\QuoteRepository;

class InMemoryQuoteRepository implements QuoteRepository
{
    /**
     * @var Quote[]
     */
    private $quotes;

    /**
     * InMemoryQuoteRepository constructor.
     *
     * @param array|null $quotes
     */
    public function __construct(array $quotes = null)
    {
        $path_to_json = file_exists('../var') ? '../var/quotes.json' : './var/quotes.json';
        $this->quotes = $quotes ?? json_decode(file_get_contents($path_to_json), true)['quotes'];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        $quotes = [];

        foreach($this->quotes as $quote) {
            $quotes[] = new Quote($quote['author'], $quote['quote']);
        }

        return $quotes;
    }

    /**
     * {@inheritdoc}
     */
    public function findQuotesByAuthor(string $author, int $limit): array
    {
        $normalized_author_name = trim($author);
        $normalized_author_name = str_replace("-", " ", $normalized_author_name);
        $normalized_author_name = ucwords($normalized_author_name);

        $quotes = [];

        // just network delay emulation
//        sleep(3);

        foreach($this->quotes as $quote) {
            if($quote['author'] == $normalized_author_name){
                $quotes[] = new Quote($quote['author'], $quote['quote']);
            }
            if(count($quotes) >= $limit){
                return $quotes;
            }
        }

        if(empty($quotes)){
            throw new QuoteNotFoundException();
        }

        return $quotes;
    }
}
