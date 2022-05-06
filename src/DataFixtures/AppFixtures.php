<?php

namespace App\DataFixtures;

use App\Entity\Tag;
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
        $this->loadTags($manager);
        $this->loadProducts($manager);
    }

    private function loadCategory(ObjectManager $manager): void
    {
        $categories = ['Футболки', 'Бейсболки', 'Кружки', 'Наклейки', 'Значки',];
        foreach ($categories as $name) {
            $category = new Category();
            $category->setName($name);
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
        for ($i = 0; $i < 20; $i += 1) {
            $product = new Product();
            $categories = $manager->getRepository(Category::class)->findAll();
            $tags = $manager->getRepository(Tag::class)->findAll();
            $product->setName($this->faker->sentence())
                ->setCategory($categories[array_rand($categories)])
                ->setSkuNumber($this->faker->numerify('######'))
                ->setDescription($this->faker->text(300))
                ->setPrice($this->faker->randomNumber(4))
                ->setStock($this->faker->randomNumber(5))
                ->setImagePaths(['img/d.png'])
                ->addTag($tags[array_rand($tags)]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}