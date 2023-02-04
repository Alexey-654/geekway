<?php

namespace App\Domain\Entity;

use App\Application\Dto\ProductDto;
use App\Infrastructure\Repository\CategoryRepository;
use App\Infrastructure\Repository\DiscountRepository;
use App\Infrastructure\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

use function Symfony\Component\String\u;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="product")
 */
class Product
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int|null $id;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private Category $category;

    /**
     * @ORM\ManyToOne(targetEntity="Discount", inversedBy="products")
     */
    private Discount|null $discount;

    /**
     * @var Collection<int, Tag>
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
     * @ORM\JoinTable(name="product_tag")
     * @ORM\OrderBy({"name": "ASC"})
     */
    private Collection $tags;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $price;

    /**
     * @ORM\Column(type="json")
     */
    private array $stock;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private string $description;

    /**
     * @Gedmo\Slug(fields={"name", "skuNumber"})
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $slug;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $skuNumber;

    /**
     * @ORM\Column(type="json")
     */
    private array $imagePaths;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public static function create(ProductDto $productDto, ManagerRegistry $registry): self
    {
        $product              = new self();
        $product->name        = $productDto->name;
        $product->description = $productDto->description;
        $product->price       = $productDto->price;
        $product->stock       = [];
        $product->skuNumber   = $productDto->skuNumber;
        $product->imagePaths  = $productDto->imagePaths;
        $product->category    = (new CategoryRepository($registry))->find($productDto->categoryId);
        $product->discount    = (new DiscountRepository($registry))->find($productDto->discountId);

        return $product;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @param Discount $discount
     */
    public function setDiscount(Discount $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @param Collection $tags
     */
    public function setTags(Collection $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @param array $stock
     */
    public function setStock(array $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @param string $skuNumber
     */
    public function setSkuNumber(string $skuNumber): void
    {
        $this->skuNumber = $skuNumber;
    }

    /**
     * @param array $imagePaths
     */
    public function setImagePaths(array $imagePaths): void
    {
        $this->imagePaths = $imagePaths;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getImagePaths(): array
    {
        return $this->imagePaths;
    }

    public function getDescription(?int $length = null): ?string
    {
        return $length ? u($this->description)->truncate($length, '...', false) : $this->description;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getStock(): ?array
    {
        return $this->stock;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function addTag(Tag ...$tags): void
    {
        foreach ($tags as $tag) {
            if (!$this->tags->contains($tag)) {
                $this->tags->add($tag);
            }
        }
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function getDiscount(): ?Discount
    {
        return $this->discount;
    }

}