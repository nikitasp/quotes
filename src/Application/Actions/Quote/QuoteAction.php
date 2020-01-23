<?php
declare(strict_types=1);

namespace App\Application\Actions\Quote;

use App\Application\Actions\Action;
use App\Domain\Quote\QuoteCache;
use Psr\Log\LoggerInterface;

abstract class QuoteAction extends Action
{
    /**
     * @var QuoteCache
     */
    protected $quoteCache;

    /**
     * @param LoggerInterface $logger
     * @param QuoteCache  $quoteCache
     */
    public function __construct(LoggerInterface $logger, QuoteCache $quoteCache)
    {
        parent::__construct($logger);
        $this->quoteCache = $quoteCache;
    }
}
