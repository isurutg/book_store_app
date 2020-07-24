<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Category;
use App\Model\BookSearchCriteria;
use App\Service\BooksService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET", "POST"})
     */
    public function index(Request $request)
    {
        $category = $request->get('category');
        $text = $request->get('text');

        $criteria = new BookSearchCriteria();
        if (strtolower($category) !== "all") {
            $criteria->category = $category;
        }
        if (!empty($text)) {
            $criteria->text = $text;
        }

        $books = $this->getDoctrine()->getRepository(Book::class)->findBySearchCriteria($criteria);
        if ($request->isXmlHttpRequest()) {
            return $this->render('home/bookList.html.twig', [
                'controller_name' => 'HomeController',
                'books' => $books
            ]);
        } else {
            $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'books' => $books,
                'categories' => $categories
            ]);
        }
    }
}
