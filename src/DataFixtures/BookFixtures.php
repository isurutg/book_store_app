<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    private $books = [
        [
            "name" => "Then She Was Gone: A Novel",
            "author" => "Lisa Jewell",
            "description" => "",
            "price" => 850.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/91OCtNw13AL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Wonky Donkey",
            "author" => "Craig Smith",
            "description" => "",
            "price" => 500.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/71N4oeWwYlL._AC_UY218_.jpg"
        ],
        [
            "name" => "Giraffes Can't Dance",
            "author" => "Giles Andreae and Guy Parker-Rees",
            "description" => "",
            "price" => 1200.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/51qvh4MALwL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Wonderful Things You Will Be",
            "author" => "Emily Winfield Martin",
            "description" => "",
            "price" => 1050.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/91Sv0lGpX3L._AC_UY218_.jpg"
        ],
        [
            "name" => "I Love You to the Moon and Back",
            "author" => "Amelia Hepworth",
            "description" => "",
            "price" => 800.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/81eB+7+CkUL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Very Hungry Caterpillar",
            "author" => "Eric Carle",
            "description" => "",
            "price" => 950.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/71KilybDOoL._AC_UY218_.jpg"
        ],
        [
            "name" => "If Animals Kissed Good Night",
            "author" => "Ann Whitford Paul and David Walker",
            "description" => "",
            "price" => 450.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/817T4J3dzhL._AC_UY218_.jpg"
        ],
        [
            "name" => "The World Needs Who You Were Made to Be",
            "author" => "",
            "description" => "Joanna Gaines and Julianna Swaney",
            "price" => 1200.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/816uUvdKzmL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Rainbow Fish",
            "author" => "Marcus Pfister and J Alison James",
            "description" => "",
            "price" => 800.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/51tDi-jVLEL._AC_UY218_.jpg"
        ],
        [
            "name" => "Brown Bear, Brown Bear, What Do You See?",
            "author" => "Bill Martin Jr. and Eric",
            "description" => "",
            "price" => 450.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/81EVdWdmOKL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Giving Tree",
            "author" => "Shel Silverstein",
            "description" => "",
            "price" => 600.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/71wiGMKadmL._AC_UY218_.jpg"
        ],
        [
            "name" => "Seeds and Trees",
            "author" => "Brandon Walden and Kristen and Kevin Howdeshell",
            "description" => "",
            "price" => 1300.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/91OyCnr0k9L._AC_UY218_.jpg"
        ],
        [
            "name" => "What Should Danny Do?",
            "author" => "Adir Levy , Ganit Levy , et al.",
            "description" => "",
            "price" => 1300.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/71zvriRVHrL._AC_UY218_.jpg"
        ],
        [
            "name" => "Billie and the Brilliant Bubble",
            "author" => "Tara Travieso and Bazma Ahmad",
            "description" => "",
            "price" => 500.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/71dmuGDvLTL._AC_UY218_.jpg"
        ],
        [
            "name" => "Chicka Chicka Boom Boom",
            "author" => "Bill Martin Jr., John Archambault , et al.",
            "description" => "",
            "price" => 700.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/91UvdebBM-L._AC_UY218_.jpg"
        ],
        [
            "name" => "If You Give a Mouse a Cookie",
            "author" => "Laura Numeroff and Felicia Bond",
            "description" => "",
            "price" => 800.00,
            "category" => "Children",
            "image" => "https://www.amazon.com/images/I/51aCFGh8IBL._AC_UY218_.jpg"
        ],
        [
            "name" => "Little Fires Everywhere",
            "author" => "Celeste Ng",
            "description" => "",
            "price" => 1020.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/81Twr5vN7hL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Silent Patient",
            "author" => "Alex Michaelides",
            "description" => "",
            "price" => 1450.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/91lslnZ-btL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Silent Wife",
            "author" => "Kerry Fisher",
            "description" => "",
            "price" => 500.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/51RJOx38qKL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Dancing Girls",
            "author" => "M.M. Chouinard",
            "description" => "",
            "price" => 1000.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/71K8NIhAkoL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Secrets We Keep",
            "author" => "Kate Hewitt",
            "description" => "",
            "price" => 850.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/915IPRMVw1L._AC_UY218_.jpg"
        ],
        [
            "name" => "Camino Winds",
            "author" => "John Grisham",
            "description" => "",
            "price" => 1400.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/81B1O4tv9-L._AC_UY218_.jpg"
        ],
        [
            "name" => "The Price of Time",
            "author" => "Tim Tigner",
            "description" => "",
            "price" => 1500.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/71sGmtrMwrL._AC_UY218_.jpg"
        ],
        [
            "name" => "Sold on a Monday",
            "author" => "Kristina McMorris",
            "description" => "",
            "price" => 950.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/815LEcMJsaL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Drop",
            "author" => "Michael Connelly",
            "description" => "",
            "price" => 1200.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/81vusGT4w5L._AC_UY218_.jpg"
        ],
        [
            "name" => "The Woman I Was Before",
            "author" => "Kerry Fisher",
            "description" => "",
            "price" => 600.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/6131E73CYzL._AC_UY218_.jpg"
        ],
        [
            "name" => "Ordinary Grace",
            "author" => "William Kent Krueger",
            "description" => "",
            "price" => 1500.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/710JvWMuVpL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Silent Daughter",
            "author" => "Claire Amarti",
            "description" => "",
            "price" => 1200.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/813Ja4l6zHL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Order",
            "author" => "Daniel Silva",
            "description" => "",
            "price" => 850.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/91sI-ylI+jL._AC_UY218_.jpg"
        ],
        [
            "name" => "The Tuscan Secret",
            "author" => "Angela Petch",
            "description" => "",
            "price" => 500.00,
            "category" => "Fiction",
            "image" => "https://www.amazon.com/images/I/81PI7xCj8ML._AC_UY218_.jpg"
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->books as $book) {
            $newBook = new Book();
            $newBook->setName($book["name"]);
            $newBook->setAuthor($book["author"]);
            $newBook->setPrice($book["price"]);
            $newBook->setImage($book["image"]);
            $newBook->setCategory($this->getReference($book{"category"}));
            $manager->persist($newBook);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class
        );
    }
}
