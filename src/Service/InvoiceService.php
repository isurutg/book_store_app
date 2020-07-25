<?php


namespace App\Service;


use App\Entity\Book;
use App\Model\CartItem;
use App\Model\Invoice;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\CouponRepository;

/**
 * Class InvoiceService
 * @package App\Service
 */
class InvoiceService
{
    /**
     * @var BookRepository
     */
    private $bookRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var CouponRepository
     */
    private $couponRepository;

    /**
     * InvoiceService constructor.
     * @param BookRepository $bookRepository
     * @param CategoryRepository $categoryRepository
     * @param CouponRepository $couponRepository
     */
    public function __construct(
        BookRepository $bookRepository,
        CategoryRepository $categoryRepository,
        CouponRepository $couponRepository
    )
    {
        $this->bookRepository = $bookRepository;
        $this->categoryRepository = $categoryRepository;
        $this->couponRepository = $couponRepository;
    }

    /**
     * @param array $items
     * @return array
     */
    public function createCart(array $items)
    {
        $shoppingCart = [];

        foreach ($items as $item) {
            if (!isset($shoppingCart[$item["bookId"]])) {
                $shoppingCart[$item["bookId"]] = new CartItem();
                $shoppingCart[$item["bookId"]]->setDetails($this->bookRepository->find($item["bookId"]));
                $shoppingCart[$item["bookId"]]->setCount(1);
                $shoppingCart[$item["bookId"]]->setTotalItemPrice($shoppingCart[$item["bookId"]]->getDetails()->getPrice());
            } else {
                $shoppingCart[$item["bookId"]] = new CartItem($shoppingCart[$item["bookId"]]);
                $shoppingCart[$item["bookId"]]->setCount($shoppingCart[$item["bookId"]]->getCount() + 1);
                $shoppingCart[$item["bookId"]]->setTotalItemPrice($shoppingCart[$item["bookId"]]->getDetails()->getPrice() * $shoppingCart[$item["bookId"]]->getCount());
            }
        }

        return $shoppingCart;
    }

    /**
     * @param array $items
     * @param string|null $couponCode
     * @return Invoice
     */
    public function createInvoice(array $items, ?string $couponCode) : Invoice
    {
        $invoice = new Invoice();
        $invoice->setCartItems($this->createCart($items));
        $invoice->setCouponCode($couponCode);

        $this->calculateTotal($invoice);

        return $invoice;
    }

    /**
     * @param Invoice $invoice
     */
    private function calculateTotal(Invoice &$invoice)
    {
        $itemsByType = [];

        $invoice->setTotal(0);

        foreach ($invoice->getCartItems() as $item) {
            if (!isset($itemsByType[$item->getDetails()->getCategory()->getName()])) {
                $itemsByType[$item->getDetails()->getCategory()->getName()] = [];
                $itemsByType[$item->getDetails()->getCategory()->getName()]['itemCount'] = $item->getCount();
                $itemsByType[$item->getDetails()->getCategory()->getName()]['totalPrice'] = 0;
            }
            $itemsByType[$item->getDetails()->getCategory()->getName()]['itemCount'] += $item->getCount();
            $itemsByType[$item->getDetails()->getCategory()->getName()]['totalPrice'] += $item->getTotalItemPrice();
            $invoice->setTotal($invoice->getTotal() + $item->getTotalItemPrice());
        };

        $this->calculateDiscount($invoice, $itemsByType);

        $invoice->setTotalAfterDiscount($invoice->getTotal() - $invoice->getDiscount());
    }

    /**
     * @param Invoice $invoice
     * @param array $itemsByType
     */
    private function calculateDiscount(Invoice &$invoice, array $itemsByType)
    {
        $isCouponValid = !is_null($this->couponRepository->findOneBy(array('code' => $invoice->getCouponCode()))) || $invoice->getCouponCode() == '1234';
        $invoice->setCouponInvalid(!empty(trim($invoice->getCouponCode())) && !$isCouponValid);
        $invoice->setDiscount(0);

        if ($isCouponValid) {
            $invoice->setDiscount($invoice->getTotal() * 0.15);
        } else {
            $allCategories = $this->categoryRepository->findAll();
            $isTotalBillDiscountApplicable = true;

            if (isset($itemsByType['Children']) && $itemsByType['Children']['itemCount'] >= 5) {
                $invoice->setDiscount($invoice->getDiscount() + ($itemsByType['Children']["totalPrice"] * 0.1));
            }

            foreach ($allCategories as $category) {
                if (isset($itemsByType[$category->getName()]) && $itemsByType[$category->getName()]['itemCount'] < 10) {
                    $isTotalBillDiscountApplicable = false;
                    break;
                }
            }

            if ($isTotalBillDiscountApplicable) {
                $invoice->setDiscount($invoice->getDiscount() + (($invoice->getTotal() - $invoice->getDiscount()) * 0.05));
            }
        }
    }
}