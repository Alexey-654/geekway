<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;

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
        $this->loadProducts($manager);
    }

    private function loadProducts(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i += 1) {
            $product = new Product();
            $product->setName($this->faker->sentence())
                ->setCategoryId($this->faker->numberBetween(1, 4))
                ->setSkuNumber($this->faker->numerify('######'))
                ->setDescription($this->faker->text(300))
                ->setPrice($this->faker->randomNumber(3))
                ->setStock($this->faker->randomNumber(5))
                ->setImagePaths(['img/d.png']);
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function loadCategory(ObjectManager $manager): void
    {
        foreach ($this->getCategoryName() as $name) {
            $categories = new Category();
            $categories->setName($name);
            $manager->persist($categories);
        }

        $manager->flush();
    }

    private function getCategoryName(): array
    {
        return [
            'Футболки',
            'Бейсболки',
            'Кружки',
            'Наклейки',
            'Значки',
        ];
    }
}