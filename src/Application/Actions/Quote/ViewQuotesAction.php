<?php
declare(strict_types=1);

namespace App\Application\Actions\Quote;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Quote\QuoteBadRequestException;

class ViewQuotesAction extends QuoteAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $quoteAuthor = $this->resolveArg('quote_author');
        $limit = $this->request->getQueryParams()['limit'] ?? 1;
        if($limit > 10){
//            throw new QuoteNotFoundException();
            throw new QuoteBadRequestException();
        }
        $quotes = $this->quoteCache->findQuotesByAuthor($quoteAuthor, (int) $limit);

        $this->logger->info("Quote Author: `$quoteAuthor` was viewed.");

        return $this->respondWithData($quotes);
    }
}
