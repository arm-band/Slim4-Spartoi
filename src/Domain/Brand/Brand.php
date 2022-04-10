<?php

declare(strict_types=1);

namespace App\Domain\Brand;

use JsonSerializable;

class Brand implements JsonSerializable
{
    private ?int $id;

    private string $brandname;

    private string $name;

    public function __construct(?int $id, string $brandname, string $name)
    {
        $this->id = $id;
        $this->brandname = strtolower($brandname);
        $this->name = ucfirst($name);
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


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'brandname' => $this->brandname,
            'name'      => $this->name,
        ];
    }
}
