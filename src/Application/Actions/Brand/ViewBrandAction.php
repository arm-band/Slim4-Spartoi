<?php

declare(strict_types=1);

namespace App\Application\Actions\Brand;

use Psr\Http\Message\ResponseInterface as Response;

class ViewBrandAction extends BrandAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $brandId = (int) $this->resolveArg('id');
        $brand = $this->brandRepository->findBrandOfId($brandId);

        $this->logger->info("Brand of id `${brandId}` was viewed.");

        return $this->respondWithData($brand);
    }
}
