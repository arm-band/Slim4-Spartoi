<?php

declare(strict_types=1);

namespace App\Domain\BrandUser;

use App\Domain\DomainException\DomainRecordNotFoundException;

class BrandUserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The branduser you requested does not exist.';
}
