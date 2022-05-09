<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Brand;

use App\Domain\Brand\Brand;
use App\Domain\Brand\BrandNotFoundException;
use App\Domain\Brand\BrandRepository;
use Psr\Container\ContainerInterface;
use App\Application\DBConnection\DBConnectionInterface;
use Illuminate\Database\Eloquent\Model;

class DBBrandRepository extends Model implements BrandRepository
{
    /**
     * @var array
     */
    private array $brands;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'brands';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';
    const CREATED_AT = 'created_at';

    /**
     * @param ContainerInterface $c
     * @param Brand[]|null $brands
     */
    public function __construct(ContainerInterface $c, array $brands = null)
    {
        $dbConnect = $c->get(DBConnectionInterface::class)->get();
        $dbBrands = $dbConnect->table($this->table)->get();
        $brandsArray = [];
        foreach ($dbBrands as $val) {
            $brandsArray[$val->id] = new Brand(
                $val->id,
                $val->brandname,
                $val->name
            );
        }
        $this->brands = $brands ?? $brandsArray;
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
