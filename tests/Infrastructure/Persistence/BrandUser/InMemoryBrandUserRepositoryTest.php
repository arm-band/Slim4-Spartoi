<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\BrandUser;

use App\Domain\BrandUser\BrandUser;
use App\Domain\BrandUser\BrandUserNotFoundException;
use App\Infrastructure\Persistence\BrandUser\InMemoryBrandUserRepository;
use Tests\TestCase;

class InMemoryBrandUserRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $branduser = new BrandUser(1, 'microsoft', 'Microsoft', 'bill.gates', 'Bill', 'Gates');
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();
        $brandUserRepository = new InMemoryBrandUserRepository($container, [1 => $branduser]);

        $this->assertEquals([$branduser], $brandUserRepository->findAll());
    }

    public function testFindAllBrandUsersByDefault()
    {
        $brandusers = [
            1 => new BrandUser(1, 'microsoft', 'Microsoft', 'bill.gates', 'Bill', 'Gates'),
            2 => new BrandUser(2, 'apple', 'Apple', 'steve.jobs', 'Steve', 'Jobs'),
            3 => new BrandUser(3, 'meta', 'Meta', 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            4 => new BrandUser(4, 'snapchat', 'Snapchat', 'evan.spiegel', 'Evan', 'Spiegel'),
            5 => new BrandUser(5, 'twitter', 'Twitter', 'jack.dorsey', 'Jack', 'Dorsey'),
        ];
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();
        $brandUserRepository = new InMemoryBrandUserRepository($container);

        $this->assertEquals(array_values($brandusers), $brandUserRepository->findAll());
    }

    public function testFindBrandUserOfId()
    {
        $branduser = new BrandUser(1, 'microsoft', 'Microsoft', 'bill.gates', 'Bill', 'Gates');
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();
        $brandUserRepository = new InMemoryBrandUserRepository($container, [1 => $branduser]);

        $this->assertEquals($branduser, $brandUserRepository->findBrandUserOfId(1));
    }

    public function testFindBrandUserOfIdThrowsNotFoundException()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();
        $brandUserRepository = new InMemoryBrandUserRepository($container, []);
        $this->expectException(BrandUserNotFoundException::class);
        $brandUserRepository->findBrandUserOfId(1);
    }
}
