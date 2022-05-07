<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Brand;

use App\Domain\Brand\Brand;
use App\Domain\Brand\BrandNotFoundException;
use App\Domain\Brand\BrandRepository;

class DBBrandRepository implements BrandRepository
{
    /**
     * @var Brand[]
     */
    private array $brands;

    /**
     * @param Brand[]|null $brands
     */
    public function __construct(array $brands = null)
    {
        $this->brands = $brands ?? [
            1 => new Brand(1, 'microsoft', 'Microsoft'),
            2 => new Brand(2, 'apple', 'Apple'),
            3 => new Brand(3, 'meta', 'Meta'),
            4 => new Brand(4, 'snapchat', 'Snapchat'),
            5 => new Brand(5, 'twitter', 'Twitter'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->brands);
    }

    /**
     * {@inheritdoc}
     */
    public function findBrandOfId(int $id): Brand
    {
        if (!isset($this->brands[$id])) {
            throw new BrandNotFoundException();
        }

        return $this->brands[$id];
    }
}
