<?php
declare(strict_types=1);

namespace Tests\Domain\Quote;

use App\Domain\Quote\Quote;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    public function quoteProvider()
    {
        return [
            ['Bill Gates', '640K ought to be enough for anyone'],
            ['Steve Jobs', 'You\'re fired!'],
        ];
    }

    /**
     * @dataProvider quoteProvider
     * @param $author
     * @param $quote
     */
    public function testGetters($author, $quote)
    {
        $quoteObj = new Quote($author, $quote);

        $this->assertEquals($author, $quoteObj->getAuthor());
        $this->assertEquals($quote, $quoteObj->getQuote());
    }

    /**
     * @dataProvider quoteProvider
     * @param $author
     * @param $quote
     */
    public function testJsonSerialize($author, $quote)
    {
        $quote = new Quote($author, $quote);

        $expectedPayload = json_encode(strtoupper($quote->getQuote()));

        $this->assertEquals($expectedPayload, json_encode($quote));
    }
}
