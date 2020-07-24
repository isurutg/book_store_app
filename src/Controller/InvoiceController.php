<?php

namespace App\Controller;

use App\Service\InvoiceService;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * @Route("/checkout", name="checkout")
     */
    public function index()
    {
        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController'
        ]);
    }

    /**
     * @Route("/invoice", name="invoice", methods={"POST"})
     */
    public function getInvoice(Request $request)
    {
        $items = $request->get('cart') ?? [];
        $coupon = $request->get('coupon') ?? null;

        $cartData = $this->invoiceService->createInvoice($items, $coupon);
        return $this->render('invoice/invoice.html.twig', [
            'controller_name' => 'InvoiceController',
            'invoice' => $cartData
        ]);
    }

    /**
     * @Route("/cart", name="cart", methods={"POST"})
     */
    public function getCart(Request $request)
    {
        $items = $request->get('cart') ?? [];
        $coupon = $request->get('coupon') ?? null;

        $invoice = $this->invoiceService->createInvoice($items, $coupon);
        return $this->render('shared/cart.html.twig', [
            'controller_name' => 'CartController',
            'cartItems' => $invoice->getCartItems(),
            'totalPrice' => $invoice->getTotalAfterDiscount()
        ]);
    }
}
