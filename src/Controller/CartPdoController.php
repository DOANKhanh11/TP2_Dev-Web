<?php

namespace Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Models\ProductPdoDataStore;
use Models\CartPdoDataStore;

class CartPdoController extends AbstractCartController
{
    protected function initStore()
    {
        $this->store = new CartPdoDataStore();

        $params = require __DIR__ . '/../config/params.php';
        $this->baseUrl = $params['pdo_baseUrl'];
    }

    private function getOrCreateCart()
    {
        $cartId = 'default'; // Panier unique
        $cart = $this->store->getById($cartId);
        if (!$cart) {
            $cart = $this->store->create([]);
            $cart['id'] = $cartId;
        }
        return $cart;
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        return new RedirectResponse($this->baseUrl . '/cart');
    }

    public function show($id = null)
    {
        $cart = $this->getOrCreateCart();
        return $this->view->render('cart/show', [
            'baseUrl' => $this->baseUrl,
            'cart'    => $cart
        ]);
    }

    public function addProduct(Request $request, $productId)
    {
        $cart = $this->getOrCreateCart();
        $quantity = $request->request->get('quantity', 1);
        $this->store->addItem($cart['id'], $productId, (int)$quantity);
        return new RedirectResponse($this->baseUrl . '/cart');
    }

    public function removeProduct($productId)
    {
        $cart = $this->getOrCreateCart();
        $this->store->removeItem($cart['id'], $productId);
        return new RedirectResponse($this->baseUrl . '/cart');
    }

    public function updateQuantity(Request $request, $productId)
    {
        $cart = $this->getOrCreateCart();
        $quantity = $request->request->get('quantity', 0);
        if ($quantity <= 0) {
            $this->store->removeItem($cart['id'], $productId);
        } else {
            $this->store->addOrUpdateItem($cart['id'], $productId, (int)$quantity);
        }
        return new RedirectResponse($this->baseUrl . '/cart');
    }

}
