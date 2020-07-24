<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private $categories = [
        [
            "name" => "Children",
            "description" => "Books for children"
        ],
        [
            "name" => "Fiction",
            "description" => "Books for all"
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->categories as $category) {
            $newCategory = new Category();
            $newCategory->setName($category["name"]);
            $newCategory->setDescription($category["description"]);
            $manager->persist($newCategory);
            $this->addReference($category["name"], $newCategory);
        }

        $manager->flush();
    }
}
