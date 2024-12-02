<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName($faker->words(3, true));
            $product->setDescription($faker->paragraph());
            $product->setPrice($faker->numberBetween(100, 1000));
            $product->setCreateAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 years', 'now')));
            
            $randomCategoryIndex = rand(0, CategoryFixtures::getCategoryCount() - 1);
            $category = $this->getReference(CategoryFixtures::CATEGORY_REFERENCE . $randomCategoryIndex, \App\Entity\Category::class);
            $product->setCategory($category);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}