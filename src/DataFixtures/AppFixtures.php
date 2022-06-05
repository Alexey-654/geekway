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
        $this->loadMiscProducts($manager);
        $this->loadClothesProducts($manager);
    }

    private function loadCategory(ObjectManager $manager): void
    {
        $categories = ['Одежда', 'Кружки', 'Наклейки', 'Значки',];
        foreach ($categories as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
        $manager->flush();

        $subCategories = ['Футболки', 'Худи', 'Бейсболки'];
        $parent = $manager
            ->getRepository(Category::class)
            ->findOneBy(['name' => 'Одежда']);
        foreach ($subCategories as $name) {
            $category = new Category();
            $category->setName($name)
                ->setParent($parent);
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

    private function loadMiscProducts(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findBy(['name' => ['Кружки', 'Наклейки', 'Значки']]);
        $tags = $manager->getRepository(Tag::class)->findAll();
        $discounts = $manager->getRepository(Discount::class)->findAll();
        for ($i = 0; $i < 20; $i += 1) {
            $tagsRand = array_rand($tags, 2);
            $product = $this->setCommonPartForAllProduct(new MiscProduct());
            $product->setCategory($categories[array_rand($categories)])
                ->addTag($tags[$tagsRand[0]], $tags[$tagsRand[1]])
                ->setStock(rand(0, 200))
                ->setImagePaths(['img/misc1.jpg', 'img/d2.jpg', 'img/d3.jpg']);
            $i % 4 != 0 ?: $product->setDiscount($discounts[array_rand($discounts)]);
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function loadClothesProducts(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findBy(['name' => ['Футболки', 'Худи', 'Бейсболки']]);
        $tags = $manager->getRepository(Tag::class)->findAll();
        $discounts = $manager->getRepository(Discount::class)->findAll();
        for ($i = 0; $i < 20; $i += 1) {
            $tagsRand = array_rand($tags, 2);
            $product = $this->setCommonPartForAllProduct(new ClothesProduct());
            $product->setCategory($categories[array_rand($categories)])
                ->addTag($tags[$tagsRand[0]], $tags[$tagsRand[1]])
                ->setStock(['s' => 23, 'm' => 5, 'l' => 12, 'xl' => 0])
                ->setImagePaths(['img/d1.png', 'img/d2.jpg', 'img/d3.jpg']);
            $i % 4 != 0 ?: $product->setDiscount($discounts[array_rand($discounts)]);
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function setCommonPartForAllProduct($product)
    {
        $product->setName($this->faker->sentence())
            ->setSkuNumber($this->faker->numerify('######'))
            ->setDescription($this->faker->text(300))
            ->setPrice($this->faker->randomNumber(4));

        return $product;
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

}