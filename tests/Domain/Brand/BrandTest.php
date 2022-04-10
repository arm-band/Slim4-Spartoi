<?php

declare(strict_types=1);

namespace Tests\Domain\Brand;

use App\Domain\Brand\Brand;
use Tests\TestCase;

class BrandTest extends TestCase
{
    public function brandProvider(): array
    {
        return [
            [1, 'microsoft', 'Microsoft'],
            [2, 'apple', 'Apple'],
            [3, 'meta', 'Meta'],
            [4, 'snapchat', 'Snapchat'],
            [5, 'twitter', 'Twitter'],
        ];
    }

    /**
     * @dataProvider brandProvider
     * @param int    $id
     * @param string $brandname
     * @param string $name
     */
    public function testGetters(int $id, string $brandname, string $name)
    {
        $brand = new Brand($id, $brandname, $name);

        $this->assertEquals($id, $brand->getId());
        $this->assertEquals($brandname, $brand->getBrandname());
        $this->assertEquals($name, $brand->getName());
    }

    /**
     * @dataProvider brandProvider
     * @param int    $id
     * @param string $brandname
     * @param string $name
     */
    public function testJsonSerialize(int $id, string $brandname, string $name)
    {
        $brand = new Brand($id, $brandname, $name);

        $expectedPayload = json_encode([
            'id'        => $id,
            'brandname' => $brandname,
            'name'      => $name,
        ]);

        $this->assertEquals($expectedPayload, json_encode($brand));
    }
}
