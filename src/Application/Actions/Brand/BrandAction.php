<?php

declare(strict_types=1);

namespace App\Application\Actions\Brand;

use App\Application\Actions\Action;
use App\Domain\Brand\BrandRepository;
use Psr\Log\LoggerInterface;

abstract class BrandAction extends Action
{
    protected BrandRepository $brandRepository;

    public function __construct(LoggerInterface $logger, BrandRepository $brandRepository)
    {
        parent::__construct($logger);
        $this->brandRepository = $brandRepository;
    }
}
