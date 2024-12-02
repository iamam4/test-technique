<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERENCE = 'category_';
    private const CATEGORY_COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        $categoryNames = [];
        for ($i = 0; $i < self::CATEGORY_COUNT; $i++) {
            $categoryNames[] = $faker->unique()->word();
        }

        foreach ($categoryNames as $index => $name) {
            $category = new Category();
            $category->setName($name);
            
            $this->addReference(self::CATEGORY_REFERENCE . $index, $category);
            
            $manager->persist($category);
        }

        $manager->flush();
    }

    public static function getCategoryCount(): int
    {
        return self::CATEGORY_COUNT;
    }
}