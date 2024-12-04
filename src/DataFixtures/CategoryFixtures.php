<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERENCE = 'category_';

    private const SCHOOL_CATEGORIES = [
        'Desks',
        'Chairs',
        'Whiteboards',
        'Storage',
        'Tables',
        'Bookshelves',
        'Filing Cabinets',
        'Teacher Desks',
        'Lab Equipment',
        'Lockers'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SCHOOL_CATEGORIES as $index => $name) {
            $category = new Category();
            $category->setName($name);
            
            $this->addReference(self::CATEGORY_REFERENCE . $index, $category);
            
            $manager->persist($category);
        }

        $manager->flush();
    }

    public static function getCategoryCount(): int
    {
        return count(self::SCHOOL_CATEGORIES);
    }
}