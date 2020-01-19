<?php
declare(strict_types=1);

namespace App\Domain\Quote;

use JsonSerializable;

class Quote implements JsonSerializable
{
    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $quote;

    /**
     * @param string  $author
     * @param string  $quote
     */
    public function __construct(string $author, string $quote)
    {
        $this->author = $author;
        $this->quote = $quote;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return strtoupper($this->quote);
    }
}
