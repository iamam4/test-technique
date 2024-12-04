<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Category;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private const PRODUCT_TEMPLATES = [
        'Desks' => [
            ['Student Desk Standard', 'Durable student desk with storage', 199],
            ['Standing Desk', 'Adjustable height standing desk', 299],
            ['Computer Workstation', 'Desktop computer workstation with cable management', 349]
        ],
        'Chairs' => [
            ['Student Chair', 'Ergonomic student chair', 89],
            ['Teacher Chair', 'Comfortable office chair for teachers', 159],
            ['Stackable Chair', 'Space-saving stackable chair', 69]
        ],
        'Whiteboards' => [
            ['Large Whiteboard', '240x120cm magnetic whiteboard', 199],
            ['Mobile Whiteboard', 'Double-sided wheeled whiteboard', 299],
            ['Interactive Board', 'Digital interactive whiteboard', 999]
        ],
        'Storage' => [
            ['Supply Cabinet', 'Lockable metal supply cabinet', 399],
            ['Student Lockers', '6-compartment student locker unit', 599],
            ['Mobile Storage Cart', 'Rolling storage cart', 249]
        ],
        'Tables' => [
            ['Study Table', '4-person study table', 299],
            ['Lab Table', 'Chemical resistant lab table', 499],
            ['Conference Table', 'Teacher conference table', 699]
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // For each category in CategoryFixtures
        for ($categoryIndex = 0; $categoryIndex < CategoryFixtures::getCategoryCount(); $categoryIndex++) {
            $category = $this->getReference(CategoryFixtures::CATEGORY_REFERENCE . $categoryIndex, Category::class);
            $categoryName = $category->getName();

            // If we have specific products for this category
            if (isset(self::PRODUCT_TEMPLATES[$categoryName])) {
                foreach (self::PRODUCT_TEMPLATES[$categoryName] as [$name, $description, $basePrice]) {
                    $product = new Product();
                    $product->setName($name);
                    $product->setDescription($description);
                    // Add some price variation
                    $product->setPrice($basePrice + $faker->numberBetween(-20, 50));
                    $product->setCreateAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months', 'now')));
                    $product->setCategory($category);

                    $manager->persist($product);
                }
            } else {
                // Generic products for categories without templates
                for ($i = 0; $i < 3; $i++) {
                    $product = new Product();
                    $product->setName($categoryName . ' ' . $faker->words(2, true));
                    $product->setDescription($faker->sentence());
                    $product->setPrice($faker->numberBetween(100, 800));
                    $product->setCreateAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months', 'now')));
                    $product->setCategory($category);

                    $manager->persist($product);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}