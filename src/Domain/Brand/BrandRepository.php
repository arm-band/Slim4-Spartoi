<?php

declare(strict_types=1);

namespace App\Domain\Brand;

interface BrandRepository
{
    /**
     * @return Brand[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Brand
     * @throws BrandNotFoundException
     */
    public function findBrandOfId(int $id): Brand;
}
