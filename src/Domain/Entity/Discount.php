<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\DiscountRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DiscountRepository::class, readOnly: false)]
class Discount
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int|null $id;

    #[ORM\Column(type: Types::STRING, unique: true, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private string $name;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private float $discountPercent;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $activeTill;

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

    public function getActiveTill(): DateTimeImmutable
    {
        return $this->activeTill;
    }

    public function setActiveTill(DateTimeImmutable $activeTill): void
    {
        $this->activeTill = $activeTill;
    }
}
