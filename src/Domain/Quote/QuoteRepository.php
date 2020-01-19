<?php
declare(strict_types=1);

namespace App\Domain\Quote;

interface QuoteRepository
{
    /**
     * @return Quote[]
     */
    public function findAll(): array;

    /**
     * @param string $author
     * @param int $limit
     * @return array
     * @throws QuoteNotFoundException
     */
    public function findQuotesByAuthor(string $author, int $limit): array;
}
