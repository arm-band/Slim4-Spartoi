<?php

declare(strict_types=1);

namespace App\Domain\Brand;

use App\Domain\DomainException\DomainRecordNotFoundException;

class BrandNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The brand you requested does not exist.';
}
