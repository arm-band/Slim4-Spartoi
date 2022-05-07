<?php

declare(strict_types=1);

namespace App\Domain\BrandUser;

interface BrandUserRepository
{
    /**
     * @return BrandUser[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return BrandUser
     * @throws BrandUserNotFoundException
     */
    public function findBrandUserOfId(int $id): BrandUser;
}
