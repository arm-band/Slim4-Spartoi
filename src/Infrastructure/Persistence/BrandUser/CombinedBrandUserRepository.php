<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\BrandUser;

use Psr\Container\ContainerInterface;
use App\Domain\Brand\Brand;
use App\Domain\Brand\BrandRepository;
use App\Domain\User\UserRepository;
use App\Domain\BrandUser\BrandUser;
use App\Domain\BrandUser\BrandUserNotFoundException;
use App\Domain\BrandUser\BrandUserRepository;

class CombinedBrandUserRepository implements BrandUserRepository
{
    /**
     * @var BrandUser[]
     */
    private array $brandusers;

    /**
     * @param ContainerInterface $c
     * @param BrandUser[]|null $brandusers
     */
    public function __construct(ContainerInterface $c, array $brandusers = null)
    {
        $brandRepository = $c->get(BrandRepository::class);
        $userRepository = $c->get(UserRepository::class);

        $joinedbrandsers = [];
        foreach ($userRepository->findAll() as $val) {
            if($brandRepository->findBrandOfId($val->getId()) instanceof Brand) {
                $joinedbrandsers[$val->getId()] = new BrandUser(
                    $val->getId(),
                    $brandRepository->findBrandOfId($val->getId())->getBrandname(),
                    $brandRepository->findBrandOfId($val->getId())->getName(),
                    $val->getUsername(),
                    $val->getFirstName(),
                    $val->getLastName()
                );
            }
        }
        $this->brandusers = $brandusers ?? $joinedbrandsers;
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
