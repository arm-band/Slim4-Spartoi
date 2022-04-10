<?php

declare(strict_types=1);

namespace App\Application\Actions\Brand;

use Psr\Http\Message\ResponseInterface as Response;

class ListBrandsAction extends BrandAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $brands = $this->brandRepository->findAll();

        $this->logger->info("Brands list was viewed.");

        return $this->respondWithData($brands);
    }
}
