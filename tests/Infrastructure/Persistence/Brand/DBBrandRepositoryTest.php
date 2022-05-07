<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Brand;

use App\Domain\Brand\Brand;
use App\Domain\Brand\BrandNotFoundException;
use App\Infrastructure\Persistence\Brand\DBBrandRepository;
use Tests\TestCase;

class DBBrandRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $brand = new Brand(1, 'microsoft', 'Microsoft');

        $brandRepository = new DBBrandRepository([1 => $brand]);

        $this->assertEquals([$brand], $brandRepository->findAll());
    }

    public function testFindAllBrandsByDefault()
    {
        $brands = [
            1 => new Brand(1, 'microsoft', 'Microsoft'),
            2 => new Brand(2, 'apple', 'Apple'),
            3 => new Brand(3, 'meta', 'Meta'),
            4 => new Brand(4, 'snapchat', 'Snapchat'),
            5 => new Brand(5, 'twitter', 'Twitter'),
        ];

        $brandRepository = new DBBrandRepository();

        $this->assertEquals(array_values($brands), $brandRepository->findAll());
    }

    public function testFindBrandOfId()
    {
        $brand = new Brand(1, 'microsoft', 'Microsoft');

        $brandRepository = new DBBrandRepository([1 => $brand]);

        $this->assertEquals($brand, $brandRepository->findBrandOfId(1));
    }

    public function testFindBrandOfIdThrowsNotFoundException()
    {
        $brandRepository = new DBBrandRepository([]);
        $this->expectException(BrandNotFoundException::class);
        $brandRepository->findBrandOfId(1);
    }
}
