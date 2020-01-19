<?php
declare(strict_types=1);

namespace App\Application\Actions\Quote;

use Psr\Http\Message\ResponseInterface as Response;

class ViewQuotesAction extends QuoteAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $quoteAuthor = $this->resolveArg('quote_author');
        $limit = $this->request->getAttributes()['limit'] ?? 1;
        $quotes = $this->quoteRepository->findQuotesByAuthor($quoteAuthor, $limit);

        $this->logger->info("Quote Author: `$quoteAuthor` was viewed.");

        return $this->respondWithData($quotes);
    }
}