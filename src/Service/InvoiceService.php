<?php


namespace App\Service;


use App\Entity\Book;
use App\Entity\Category;
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
     * @param string|null $couponCode
     * @return Invoice
     */
    public function createInvoice(array $items, ?string $couponCode): Invoice
    {
        $invoice = new Invoice();
        $invoice->setCartItems($this->createCart($items));
        $invoice->setCouponCode($couponCode ?? '');

        $isCouponValid = !is_null($this->couponRepository->findOneBy(array('code' => $invoice->getCouponCode()))) || $invoice->getCouponCode() == '1234';
        $invoice->setCouponInvalid(!empty(trim($invoice->getCouponCode())) && !$isCouponValid);

        $invoice->setTotal($this::calculateTotal($invoice));

        $allCategories = $this->categoryRepository->findAll();
        $invoice->setDiscount($this::calculateDiscount($invoice, $allCategories));
        $invoice->setTotalAfterDiscount($invoice->getTotal() - $invoice->getDiscount());

        return $invoice;
    }

    /**
     * @param Invoice $invoice
     */
    public static function calculateTotal(Invoice $invoice)
    {
        $total = 0;

        $invoice->setTotal(0);

        foreach ($invoice->getCartItems() as $item) {
            $total += $item->getTotalItemPrice();
        }

        return $total;
    }

    /**
     * @param Invoice $invoice
     * @param Category[] $allCategories
     */
    public static function calculateDiscount(Invoice $invoice, array $allCategories)
    {
        $discount = 0;

        if (!$invoice->getCouponInvalid() && !empty($invoice->getCouponCode())) {
            $discount = $invoice->getTotal() * 0.15;
        } else {
            $itemsByType = [];
            $isTotalBillDiscountApplicable = true;

            foreach ($invoice->getCartItems() as $item) {
                if (!isset($itemsByType[$item->getDetails()->getCategory()->getName()])) {
                    $itemsByType[$item->getDetails()->getCategory()->getName()] = [];
                    $itemsByType[$item->getDetails()->getCategory()->getName()]['itemCount'] = 0;
                    $itemsByType[$item->getDetails()->getCategory()->getName()]['totalPrice'] = 0;
                }
                $itemsByType[$item->getDetails()->getCategory()->getName()]['itemCount'] += $item->getCount();
                $itemsByType[$item->getDetails()->getCategory()->getName()]['totalPrice'] += $item->getTotalItemPrice();
            }

            if (isset($itemsByType['Children']) && $itemsByType['Children']['itemCount'] >= 5) {
                $discount += $itemsByType['Children']["totalPrice"] * 0.1;
            }

            if (!$allCategories || count($allCategories) == 0) {
                $isTotalBillDiscountApplicable = false;
            } else {
                foreach ($allCategories as $category) {
                    if (isset($itemsByType[$category->getName()]) && $itemsByType[$category->getName()]['itemCount'] < 10) {
                        $isTotalBillDiscountApplicable = false;
                        break;
                    }
                }
            }

            if ($isTotalBillDiscountApplicable) {
                $discount += (($invoice->getTotal() - $discount) * 0.05);
            }
        }
        return $discount;
    }

    /**
     * @param array $items
     * @return array
     */
    private function createCart(array $items)
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
}