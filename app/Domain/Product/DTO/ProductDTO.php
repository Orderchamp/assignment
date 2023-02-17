<?php

namespace App\Domain\Product\DTO;

class ProductDTO
{
    public int $id;
    public string $name;
    public ?string $description;
    public float $price;
    public ?string $image;
    public int $quantity;

    public function __construct(int $id, string $name, ?string $description, float $price, ?string $image, int $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
        $this->quantity = $quantity;
    }
}
