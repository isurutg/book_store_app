<?php

namespace App\Tests\Service;

use App\Entity\Book;
use App\Entity\Category;
use App\Model\CartItem;
use App\Model\Invoice;
use App\Service\InvoiceService;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{

    public function testCalculateTotal()
    {
        // sample catogories
        $childrenCategory = new Category();
        $childrenCategory->setName('Children');
        $fictionCategory = new Category();
        $fictionCategory->setName('Fiction');
        $allCategories = array($childrenCategory, $fictionCategory);

        // sample books
        $childrenBook = new Book();
        $childrenBook->setName("TestBook1");
        $childrenBook->setPrice(1000);
        $childrenBook->setCategory($childrenCategory);
        $fictionBook = new Book();
        $fictionBook->setName("TestBook2");
        $fictionBook->setPrice(500);
        $fictionBook->setCategory($fictionCategory);
        $books = [$childrenBook, $fictionBook];

        // my invoice
        $invoice = new Invoice();

        // children book 4 and fiction book 4
        $cart = array_merge(
            $this->addItemsToCart($childrenBook->getName(), 4),
            $this->addItemsToCart($fictionBook->getName(), 4)
        );
        $scenarioTotal = ($childrenBook->getPrice() * 4) + ($fictionBook->getPrice() * 4);
        $childDiscount = 0;
        $totalBookCountDiscount = 0;
        $couponDiscount = 0;
        $scenarioDiscount = $childDiscount + $totalBookCountDiscount + $couponDiscount;
        $invoice->setCartItems($this->createCart($cart, $books));

        $invoice->setTotal(InvoiceService::calculateTotal($invoice));
        $invoice->setDiscount(InvoiceService::calculateDiscount($invoice, $allCategories));

        $this->assertEquals(($invoice->getTotal() - $invoice->getDiscount()), ($scenarioTotal - $scenarioDiscount), "Net Total for children x4 and fiction x4 is invalid");

        // children book 5 and fiction book 5
        $cart = array_merge(
            $this->addItemsToCart($childrenBook->getName(), 5),
            $this->addItemsToCart($fictionBook->getName(), 5)
        );
        $scenarioTotal = ($childrenBook->getPrice() * 5) + ($fictionBook->getPrice() * 5);
        $childDiscount = ($childrenBook->getPrice() * 5) * 0.1;
        $totalBookCountDiscount = 0;
        $couponDiscount = 0;
        $scenarioDiscount = $childDiscount + $totalBookCountDiscount + $couponDiscount;
        $invoice->setCartItems($this->createCart($cart, $books));

        $invoice->setTotal(InvoiceService::calculateTotal($invoice));
        $invoice->setDiscount(InvoiceService::calculateDiscount($invoice, $allCategories));

        $this->assertEquals(($invoice->getTotal() - $invoice->getDiscount()), ($scenarioTotal - $scenarioDiscount), "Net Total for children x5 and fiction x5 is invalid");

        // children book 11 and fiction book 5
        $cart = array_merge(
            $this->addItemsToCart($childrenBook->getName(), 11),
            $this->addItemsToCart($fictionBook->getName(), 5)
        );
        $scenarioTotal = ($childrenBook->getPrice() * 11) + ($fictionBook->getPrice() * 5);
        $childDiscount = ($childrenBook->getPrice() * 11) * 0.1;
        $totalBookCountDiscount = 0;
        $couponDiscount = 0;
        $scenarioDiscount = $childDiscount + $totalBookCountDiscount + $couponDiscount;
        $invoice->setCartItems($this->createCart($cart, $books));

        $invoice->setTotal(InvoiceService::calculateTotal($invoice));
        $invoice->setDiscount(InvoiceService::calculateDiscount($invoice, $allCategories));

        $this->assertEquals(($invoice->getTotal() - $invoice->getDiscount()), ($scenarioTotal - $scenarioDiscount), "Net Total for children x11 and fiction x5 is invalid");

        // children book 11 and fiction book 11
        $cart = array_merge(
            $this->addItemsToCart($childrenBook->getName(), 11),
            $this->addItemsToCart($fictionBook->getName(), 11)
        );
        $scenarioTotal = ($childrenBook->getPrice() * 11) + ($fictionBook->getPrice() * 11);
        $childDiscount = ($childrenBook->getPrice() * 11) * 0.1;
        $totalBookCountDiscount = ($scenarioTotal - $childDiscount) * 0.05;
        $couponDiscount = 0;
        $scenarioDiscount = $childDiscount + $totalBookCountDiscount + $couponDiscount;
        $invoice->setCartItems($this->createCart($cart, $books));

        $invoice->setTotal(InvoiceService::calculateTotal($invoice));
        $invoice->setDiscount(InvoiceService::calculateDiscount($invoice, $allCategories));
        $this->assertEquals(($invoice->getTotal() - $invoice->getDiscount()), ($scenarioTotal - $scenarioDiscount), "Net Total for children x11 and fiction x11 is invalid");

        // children book 11 and fiction book 11 with invalid coupon code
        $cart = array_merge(
            $this->addItemsToCart($childrenBook->getName(), 11),
            $this->addItemsToCart($fictionBook->getName(), 11)
        );
        $scenarioTotal = ($childrenBook->getPrice() * 11) + ($fictionBook->getPrice() * 11);
        $childDiscount = ($childrenBook->getPrice() * 11) * 0.1;
        $totalBookCountDiscount = ($scenarioTotal - $childDiscount) * 0.05;
        $couponDiscount = 0;
        $scenarioDiscount = $childDiscount + $totalBookCountDiscount + $couponDiscount;
        $invoice->setCartItems($this->createCart($cart, $books));
        $invoice->setCouponCode('test');
        $invoice->setCouponInvalid(true);

        $invoice->setTotal(InvoiceService::calculateTotal($invoice));
        $invoice->setDiscount(InvoiceService::calculateDiscount($invoice, $allCategories));
        $this->assertEquals(($invoice->getTotal() - $invoice->getDiscount()), ($scenarioTotal - $scenarioDiscount), "Net Total for children x11 and fiction x11 is invalid");

        // children book 11 and fiction book 11 and valid coupon code
        $cart = array_merge(
            $this->addItemsToCart($childrenBook->getName(), 11),
            $this->addItemsToCart($fictionBook->getName(), 11)
        );
        $scenarioTotal = ($childrenBook->getPrice() * 11) + ($fictionBook->getPrice() * 11);
        $childDiscount = 0;
        $totalBookCountDiscount = 0;
        $couponDiscount = $scenarioTotal * 0.15;
        $scenarioDiscount = $childDiscount + $totalBookCountDiscount + $couponDiscount;
        $invoice->setCartItems($this->createCart($cart, $books));
        $invoice->setCouponCode('test');
        $invoice->setCouponInvalid(false);

        $invoice->setTotal(InvoiceService::calculateTotal($invoice));
        $invoice->setDiscount(InvoiceService::calculateDiscount($invoice, $allCategories));
        $this->assertEquals(($invoice->getTotal() - $invoice->getDiscount()), ($scenarioTotal - $scenarioDiscount), "Net Total for children x11 and fiction x11 with coupon code is invalid");

    }

    private function createCart(array $items, array $books)
    {
        $shoppingCart = [];
        foreach ($items as $item) {
            $book = array_filter($books, function ($v) use (&$item) {
                if ($v->getName() == $item) return true;
            });

            if (!isset($shoppingCart[$item])) {
                $shoppingCart[$item] = new CartItem();
                $shoppingCart[$item]->setDetails(reset($book));
                $shoppingCart[$item]->setCount(1);
                $shoppingCart[$item]->setTotalItemPrice($shoppingCart[$item]->getDetails()->getPrice());
            } else {
                $shoppingCart[$item] = new CartItem($shoppingCart[$item]);
                $shoppingCart[$item]->setCount($shoppingCart[$item]->getCount() + 1);
                $shoppingCart[$item]->setTotalItemPrice($shoppingCart[$item]->getDetails()->getPrice() * $shoppingCart[$item]->getCount());
            }
        }
        return $shoppingCart;
    }

    private function addItemsToCart($item, $count)
    {
        $cart = [];
        for ($i = 1; $i <= $count; $i++) {
            array_push($cart, $item);
        }
        return $cart;
    }

}
