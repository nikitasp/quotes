<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Quote;

use App\Domain\Quote\Quote;
use App\Domain\Quote\QuoteNotFoundException;
use App\Infrastructure\Persistence\Quote\InMemoryQuoteRepository;
use Tests\TestCase;

class InMemoryQuoteRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $quoteRepository = new InMemoryQuoteRepository([[
            'author'=>'Bill Gates',
            'quote'=>'640K ought to be enough for anyone'
        ],[
            'author'=>'Steve Jobs',
            'quote'=>'You\'re fired!'
        ]]);

        $this->assertEquals([
            new Quote('Bill Gates', '640K ought to be enough for anyone'),
            new Quote('Steve Jobs', 'You\'re fired!'),

        ], $quoteRepository->findAll());
    }

    public function testFindQuotesByAuthor()
    {
        $quoteRepository = new InMemoryQuoteRepository([[
            'author'=>'Bill Gates',
            'quote'=>'640K ought to be enough for anyone'
        ]]);

        $this->assertEquals([
            new Quote('Bill Gates', '640K ought to be enough for anyone'),
        ], $quoteRepository->findQuotesByAuthor('Bill Gates', 1));
    }

    /**
     * @expectedException \App\Domain\Quote\QuoteNotFoundException
     */
    public function testFindQuotesByAuthorThrowsNotFoundException()
    {
        $quoteRepository = new InMemoryQuoteRepository([]);
        $quoteRepository->findQuotesByAuthor('Bill Gates', 1);
    }
}
