<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\TagRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TagRepository::class, readOnly: false)]
class Tag
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int|null $id;

    #[ORM\Column(type: Types::STRING, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private string $name;

    #[ORM\Column(type: Types::STRING, unique: true)]
    #[Gedmo\Slug(fields: ["name"])]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private string $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
