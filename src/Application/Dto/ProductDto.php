<?php

namespace App\Application\Dto;

final class ProductDto
{
    public string $name;
    public int $price;
    public array $stock;
    public string $description;
    public string $skuNumber;
    public array $imagePaths;
    public int $categoryId;
    public int $discountId;
}