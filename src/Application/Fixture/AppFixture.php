<?php

namespace App\Application\Fixture;

use App\Domain\Entity\Category;
use App\Domain\Entity\Discount;
use App\Domain\Entity\Product;
use App\Domain\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;

/**
 * Load fixture data to local DB
 */
final class AppFixture extends Fixture
{
    private object $faker;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }

    /**
     * @param ObjectManager $manager
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadCategory($manager);
        $this->loadTags($manager);
        $this->loadDiscounts($manager);
        $this->loadProducts($manager);
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
        $parent        = $manager->getRepository(Category::class)->findOneBy(['name' => 'Одежда']);
        foreach ($subCategories as $name) {
            $category = new Category();
            $category->setName($name);
            $category->setParent($parent);
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

    /**
     * @throws Exception
     */
    private function loadDiscounts(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $discount = new Discount();
            $discount->setName($this->faker->sentence());
            $discount->setDiscountPercent(random_int(10, 50));
            $discount->setActiveTill($this->faker->dateTimeThisYear('1 month'));
            $manager->persist($discount);
        }

        $manager->flush();
    }

    private function loadProducts(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findBy(['name' => ['Кружки', 'Наклейки', 'Значки']]);
        $tags       = $manager->getRepository(Tag::class)->findAll();
        $discounts  = $manager->getRepository(Discount::class)->findAll();

        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName($this->faker->sentence());
            $product->setSkuNumber($this->faker->numerify('######'));
            $product->setDescription($this->faker->text(300));
            $product->setPrice($this->faker->randomNumber(4));
            $tagsRand = array_rand($tags, 2);
            $product->setCategory($categories[array_rand($categories)]);
            $product->addTag($tags[$tagsRand[0]], $tags[$tagsRand[1]]);
            $product->setStock(['oneSize' => 12]);
            $product->setImagePaths(['img/misc1.jpg', 'img/d2.jpg', 'img/d3.jpg']);
            $i % 4 !== 0 ?: $product->setDiscount($discounts[array_rand($discounts)]);
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function loadClothesProducts(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findBy(['name' => ['Футболки', 'Худи', 'Бейсболки']]);
        $tags       = $manager->getRepository(Tag::class)->findAll();
        $discounts  = $manager->getRepository(Discount::class)->findAll();

        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName($this->faker->sentence());
            $product->setSkuNumber($this->faker->numerify('######'));
            $product->setDescription($this->faker->text(300));
            $product->setPrice($this->faker->randomNumber(4));
            $tagsRand = array_rand($tags, 2);
            $product->setCategory($categories[array_rand($categories)]);
            $product->addTag($tags[$tagsRand[0]], $tags[$tagsRand[1]]);
            $product->setStock(['s' => 23, 'm' => 5, 'l' => 12, 'xl' => 0]);
            $product->setImagePaths(['img/d1.png', 'img/d2.jpg', 'img/d3.jpg']);
            $i % 4 !== 0 ?: $product->setDiscount($discounts[array_rand($discounts)]);
            $manager->persist($product);
        }

        $manager->flush();
    }

}