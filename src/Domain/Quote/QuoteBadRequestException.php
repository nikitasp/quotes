<?php
declare(strict_types=1);

namespace App\Domain\Quote;

use App\Domain\DomainException\DomainBadRequestException;


class QuoteBadRequestException extends DomainBadRequestException
{
    public $message = "You can't request more then 10 quotes";
}
