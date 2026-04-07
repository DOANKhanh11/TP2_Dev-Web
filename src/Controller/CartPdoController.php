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

    // On a qu'un seul panier, d'où le Id à "default"
    private function getOrCreateCart()
    {
        $cartId = 'default';
        $cart = $this->store->getById($cartId);
        if (!$cart) {
            $cart = $this->store->create([], $cartId);
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
        $quantity = (int)$request->request->get('quantity', 1);

        // Vérifier le stock disponible
        $productStore = new \Models\ProductPdoDataStore('products');
        $product = $productStore->getById($productId);

        if (!$product) {
            // Rediriger avec un message d'erreur
            return new RedirectResponse($this->baseUrl . '/product?error=product_not_found');
        }

        // Vérifier la quantité déjà dans le panier
        $existingQuantity = 0;
        foreach ($cart['items'] as $item) {
            if ($item['product_id'] == $productId) {
                $existingQuantity = $item['quantity'];
                break;
            }
        }

        $totalQuantity = $existingQuantity + $quantity;

        if ($totalQuantity > $product['stock']) {
            // Rediriger avec un message d'erreur
            return new RedirectResponse($this->baseUrl . '/product?error=insufficient_stock&available=' . $product['stock']);
        }

        $this->store->addItem($cart['id'], $productId, $quantity);
        return new RedirectResponse($this->baseUrl . '/product?success=product_added');
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
        $quantity = (int)$request->request->get('quantity', 0);

        if ($quantity > 0) {
            // Vérifier le stock disponible
            $productStore = new \Models\ProductPdoDataStore('products');
            $product = $productStore->getById($productId);

            if (!$product) {
                return new RedirectResponse($this->baseUrl . '/cart?error=product_not_found');
            }

            if ($quantity > $product['stock']) {
                return new RedirectResponse($this->baseUrl . '/cart?error=insufficient_stock&available=' . $product['stock']);
            }
        }

        if ($quantity <= 0) {
            $this->store->removeItem($cart['id'], $productId);
        } else {
            $this->store->addOrUpdateItem($cart['id'], $productId, $quantity);
        }
        return new RedirectResponse($this->baseUrl . '/cart');
    }

}
