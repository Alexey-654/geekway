<?php

namespace App\DataFixtures;

use App\Entity\ClothesProduct;
use App\Entity\MiscProduct;
use App\Entity\ProductType;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Discount;

class AppFixtures extends Fixture
{
    private object $faker;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadCategory($manager);
        $this->loadTags($manager);
        $this->loadDiscounts($manager);
        $this->loadProductTypes($manager);
        $this->loadProducts($manager);
    }

    private function loadCategory(ObjectManager $manager): void
    {
        $categories = ['Одежда', 'Кружки', 'Наклейки', 'Значки',];
        $subCategories = ['Футболки', 'Худи', 'Бейсболки'];
        foreach ($categories as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
        foreach ($subCategories as $name) {
            $category = new Category();
            $category->setName($name)
                ->setParent(1);
            $manager->persist($category);
        }

        $manager->flush();
    }

    private function loadTags(ObjectManager $manager): void
    {
        $tags = ['PHP', 'JS', 'Программистам', 'Дота', 'Math',];
        foreach ($tags as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            $manager->persist($tag);
        }

        $manager->flush();
    }

    private function loadProducts(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findAll();
        $tags = $manager->getRepository(Tag::class)->findAll();
        $discounts = $manager->getRepository(Discount::class)->findAll();
        $productTypes = $manager->getRepository(ProductType::class)->findAll();
        for ($i = 0; $i < 10; $i += 1) {
            $tagsRand = array_rand($tags, 2);
            $product = $i % 2 === 0 ? new ClothesProduct() : new MiscProduct();
            $product->setName($this->faker->sentence())
                ->setCategory($categories[array_rand($categories)])
                ->setType($productTypes[array_rand($productTypes)])
                ->setSkuNumber($this->faker->numerify('######'))
                ->setDescription($this->faker->text(300))
                ->setPrice($this->faker->randomNumber(4))
                ->setImagePaths(['img/d1.png', 'img/d2.jpg', 'img/d3.jpg'])
                ->addTag($tags[$tagsRand[0]], $tags[$tagsRand[1]]);
                $i % 4 != 0 ?: $product->setDiscount($discounts[array_rand($discounts)]);
            if ($i % 2 === 0) {
                $product->setStock(['s' => 23, 'm' => 5, 'l' => 12, 'xl' => 0]);
            } else {
                $product->setStock(rand(0, 200));
            }

            $manager->persist($product);
        }

        $manager->flush();
    }

    private function loadDiscounts(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i += 1) {
            $discount = new Discount();
            $discount->setName($this->faker->sentence())
                ->setDiscountPercent(rand(10, 50))
                ->setActiveTill($this->faker->dateTimeThisYear('1 month'));
            $manager->persist($discount);
        }

        $manager->flush();
    }

    private function loadProductTypes(ObjectManager $manager): void
    {
        $productTypeNames = ['одежда', 'база'];
        foreach ($productTypeNames as $name) {
            $productType = new ProductType();
            $productType->setName($name);
            $manager->persist($productType);
        }

        $manager->flush();
    }

//->setStock($this->faker->randomNumber(5))
}