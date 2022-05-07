<?php

declare(strict_types=1);

namespace App\Application\Actions\BrandUser;

use Psr\Http\Message\ResponseInterface as Response;

class ListBrandUsersAction extends BrandUserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $brandusers = $this->brandUserRepository->findAll();

        $this->logger->info("Brandusers list was viewed.");

        return $this->respondWithData($brandusers);
    }
}
