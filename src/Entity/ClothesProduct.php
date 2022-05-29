<?php

namespace App\Entity;

use App\Repository\ClothesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClothesRepository::class)
 */
class ClothesProduct extends Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $size = [];

    /**
     * @ORM\Column(type="json")
     */
    private $stock = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?array
    {
        return $this->size;
    }

    public function setSize(array $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getStock(): ?array
    {
        return $this->stock;
    }

    public function setStock(array $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}
