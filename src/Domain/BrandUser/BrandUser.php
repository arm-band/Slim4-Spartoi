<?php

declare(strict_types=1);

namespace App\Domain\BrandUser;

use JsonSerializable;

class BrandUser implements JsonSerializable
{
    private ?int $id;

    private string $brandname;

    private string $name;

    private string $username;

    private string $firstName;

    private string $lastName;

    public function __construct(?int $id, string $brandname, string $name, string $username, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->brandname = strtolower($brandname);
        $this->name = ucfirst($name);
        $this->username = strtolower($username);
        $this->firstName = ucfirst($firstName);
        $this->lastName = ucfirst($lastName);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandname(): string
    {
        return $this->brandname;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'brandname' => $this->brandname,
            'name'      => $this->name,
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }
}
