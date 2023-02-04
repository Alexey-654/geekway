<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\DiscountRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=DiscountRepository::class)
 */
class Discount
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int|null $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $name;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private float $discountPercent;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $activeTill;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDiscountPercent(): string
    {
        return $this->discountPercent;
    }

    public function setDiscountPercent(string $discountPercent): void
    {
        $this->discountPercent = $discountPercent;
    }

    public function getActiveTill(): DateTime
    {
        return $this->activeTill;
    }

    public function setActiveTill(DateTime $activeTill): void
    {
        $this->activeTill = $activeTill;
    }
}
