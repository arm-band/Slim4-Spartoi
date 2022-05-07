<?php

declare(strict_types=1);

namespace App\Application\Actions\BrandUser;

use Psr\Http\Message\ResponseInterface as Response;

class ViewBrandUserAction extends BrandUserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $branduserId = (int) $this->resolveArg('id');
        $branduser = $this->brandUserRepository->findBrandUserOfId($branduserId);

        $this->logger->info("Branduser of id `${branduserId}` was viewed.");

        return $this->respondWithData($branduser);
    }
}
