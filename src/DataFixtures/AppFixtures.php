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

    private function loadCategory(ObjectManager $manager): void
    {
        foreach ($this->getCategoryName() as $name) {
            $categories = new Category();
            $categories->setName($name);
            $manager->persist($categories);
        }

        $manager->flush();
    }

    private function loadProducts(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i += 1) {
            $product = new Product();
            $categories = $manager->getRepository(Category::class)->findAll();
            $product->setName($this->faker->sentence())
                ->setCategory($categories[$this->faker->numberBetween(0, 4)])
                ->setSkuNumber($this->faker->numerify('######'))
                ->setDescription($this->faker->text(300))
                ->setPrice($this->faker->randomNumber(4))
                ->setStock($this->faker->randomNumber(5))
                ->setImagePaths(['img/d.png']);
            $manager->persist($product);
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