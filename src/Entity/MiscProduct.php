<?php

namespace App\Entity;

use App\Repository\MiscProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MiscProductRepository::class)
 */
final class MiscProduct extends Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(string $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}
