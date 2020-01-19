<?php
declare(strict_types=1);

namespace App\Domain\Quote;

use App\Domain\DomainException\DomainRecordNotFoundException;

class QuoteNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'There is no quotes for give author :(';
}
