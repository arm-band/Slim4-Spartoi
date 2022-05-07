<?php

declare(strict_types=1);

namespace Tests\Domain\BrandUser;

use App\Domain\BrandUser\BrandUser;
use Tests\TestCase;

class BrandUserTest extends TestCase
{
    public function brandUserProvider(): array
    {
        return [
            [1, 'microsoft', 'Microsoft', 'bill.gates', 'Bill', 'Gates'],
            [2, 'apple', 'Apple', 'steve.jobs', 'Steve', 'Jobs'],
            [3, 'meta', 'Meta', 'mark.zuckerberg', 'Mark', 'Zuckerberg'],
            [4, 'snapchat', 'Snapchat', 'evan.spiegel', 'Evan', 'Spiegel'],
            [5, 'twitter', 'Twitter', 'jack.dorsey', 'Jack', 'Dorsey'],
        ];
    }

    /**
     * @dataProvider brandUserProvider
     * @param int    $id
     * @param string $brandname
     * @param string $name
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     */
    public function testGetters(int $id, string $brandname, string $name, string $username, string $firstName, string $lastName)
    {
        $brandUser = new BrandUser($id, $brandname, $name, $username, $firstName, $lastName);

        $this->assertEquals($id, $brandUser->getId());
        $this->assertEquals($brandname, $brandUser->getBrandname());
        $this->assertEquals($name, $brandUser->getName());
        $this->assertEquals($username, $brandUser->getUsername());
        $this->assertEquals($firstName, $brandUser->getFirstName());
        $this->assertEquals($lastName, $brandUser->getLastName());
    }

    /**
     * @dataProvider brandUserProvider
     * @param int    $id
     * @param string $brandname
     * @param string $name
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     */
    public function testJsonSerialize(int $id, string $brandname, string $name, string $username, string $firstName, string $lastName)
    {
        $brandUser = new BrandUser($id, $brandname, $name, $username, $firstName, $lastName);

        $expectedPayload = json_encode([
            'id'        => $id,
            'brandname' => $brandname,
            'name'      => $name,
            'username'  => $username,
            'firstName' => $firstName,
            'lastName'  => $lastName,
        ]);

        $this->assertEquals($expectedPayload, json_encode($brandUser));
    }
}
