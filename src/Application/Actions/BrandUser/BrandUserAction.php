<?php

declare(strict_types=1);

namespace App\Application\Actions\BrandUser;

use App\Application\Actions\Action;
use App\Domain\BrandUser\BrandUserRepository;
use Psr\Log\LoggerInterface;

abstract class BrandUserAction extends Action
{
    protected BrandUserRepository $brandUserRepository;

    public function __construct(LoggerInterface $logger, BrandUserRepository $brandUserRepository)
    {
        parent::__construct($logger);
        $this->brandUserRepository = $brandUserRepository;
    }
}
