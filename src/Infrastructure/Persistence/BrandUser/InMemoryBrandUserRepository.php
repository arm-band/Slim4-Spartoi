<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\BrandUser;

use App\Domain\BrandUser\BrandUser;
use App\Domain\BrandUser\BrandUserNotFoundException;
use App\Domain\BrandUser\BrandUserRepository;

class InMemoryBrandUserRepository implements BrandUserRepository
{
    /**
     * @var BrandUser[]
     */
    private array $brandusers;

    /**
     * @param BrandUser[]|null $brandusers
     */
    public function __construct(array $brandusers = null)
    {
        $this->brandusers = $brandusers ?? [
            1 => new BrandUser(1, 'microsoft', 'Microsoft', 'bill.gates', 'Bill', 'Gates'),
            2 => new BrandUser(2, 'apple', 'Apple', 'steve.jobs', 'Steve', 'Jobs'),
            3 => new BrandUser(3, 'meta', 'Meta', 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            4 => new BrandUser(4, 'snapchat', 'Snapchat', 'evan.spiegel', 'Evan', 'Spiegel'),
            5 => new BrandUser(5, 'twitter', 'Twitter', 'jack.dorsey', 'Jack', 'Dorsey'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->brandusers);
    }

    /**
     * {@inheritdoc}
     */
    public function findBrandUserOfId(int $id): BrandUser
    {
        if (!isset($this->brandusers[$id])) {
            throw new BrandUserNotFoundException();
        }

        return $this->brandusers[$id];
    }
}
