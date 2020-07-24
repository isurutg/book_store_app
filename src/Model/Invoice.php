<?php


namespace App\Model;


use App\Entity\Book;

/**
 * Class Invoice
 * @package App\Model
 */
class Invoice
{
    /**
     * @var
     */
    private $cartItems;
    /**
     * @var
     */
    private $couponCode;

    /**
     * @var
     */
    private $couponInvalid;
    /**
     * @var
     */
    private $total;
    /**
     * @var
     */
    private $discount;
    /**
     * @var
     */
    private $totalAfterDiscount;

    /**
     * @return CartItem[]
     */
    public function getCartItems()
    {
        return $this->cartItems;
    }

    /**
     * @param CartItem[] $cartItems
     * @return Invoice
     */
    public function setCartItems(array $cartItems)
    {
        $this->cartItems = $cartItems;
        return $this;
    }

    /**
     * @return string
     */
    public function getCouponCode()
    {
        return $this->couponCode;
    }

    /**
     * @param string $couponCode
     * @return Invoice
     */
    public function setCouponCode(?string $couponCode)
    {
        $this->couponCode = $couponCode;
        return $this;
    }

    /**
     * @return bool
     */
    public function getCouponInvalid()
    {
        return $this->couponInvalid;
    }

    /**
     * @param bool $couponInvalid
     * @return Invoice
     */
    public function setCouponInvalid(bool $couponInvalid)
    {
        $this->couponInvalid = $couponInvalid;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return Invoice
     */
    public function setTotal(float $total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     * @return Invoice
     */
    public function setDiscount(float $discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAfterDiscount()
    {
        return $this->totalAfterDiscount;
    }

    /**
     * @param float $totalAfterDiscount
     * @return Invoice
     */
    public function setTotalAfterDiscount(float $totalAfterDiscount)
    {
        $this->totalAfterDiscount = $totalAfterDiscount;
        return $this;
    }
}

/**
 * Class CartItem
 * @package App\Model
 */
class CartItem
{
    /**
     * @var
     */
    private $details;
    /**
     * @var
     */
    private $count;
    /**
     * @var
     */
    private $totalItemPrice;

    public function __construct(CartItem $cartItem = null)
    {
        if(!is_null($cartItem)) {
            foreach ($cartItem as $property => $value) {
                $this->$property = $value;
            }
        }
    }

    /**
     * @return Book
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param Book $details
     */
    public function setDetails(Book $details): void
    {
        $this->details = $details;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return CartItem
     */
    public function setCount(int $count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalItemPrice()
    {
        return $this->totalItemPrice;
    }

    /**
     * @param float $totalItemPrice
     * @return CartItem
     */
    public function setTotalItemPrice(float $totalItemPrice)
    {
        $this->totalItemPrice = $totalItemPrice;
        return $this;
    }

}