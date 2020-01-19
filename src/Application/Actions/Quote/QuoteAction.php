<?php
declare(strict_types=1);

namespace App\Application\Actions\Quote;

use App\Application\Actions\Action;
use App\Domain\Quote\QuoteRepository;
use Psr\Log\LoggerInterface;

abstract class QuoteAction extends Action
{
    /**
     * @var QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @param LoggerInterface $logger
     * @param QuoteRepository  $quoteRepository
     */
    public function __construct(LoggerInterface $logger, QuoteRepository $quoteRepository)
    {
        parent::__construct($logger);
        $this->quoteRepository = $quoteRepository;
    }
}
