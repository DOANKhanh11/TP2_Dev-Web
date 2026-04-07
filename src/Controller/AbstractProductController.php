<?php
namespace Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Util\View;

abstract class AbstractProductController
{
    protected $store;
    protected $view;
    protected $baseUrl;

    public function __construct()
    {
        $this->view = new View();
        $this->initStore();
    }

    abstract protected function initStore();

    public function index()
    {
        $products = $this->store->getAll();
        $lowStock = $this->store->getLowStock();
        return $this->view->render('product/list', [
            'baseUrl'  => $this->baseUrl,
            'products' => $products,
            'lowStock' => $lowStock,
        ]);
    }

    public function search(Request $request)
    {
        $filters = [
            'name'      => $request->query->get('name', ''),
            'category'  => $request->query->get('category', ''),
            'origin'    => $request->query->get('origin', ''),
            'tag'       => $request->query->get('tag', ''),
            'price_min' => $request->query->get('price_min', ''),
            'price_max' => $request->query->get('price_max', ''),
        ];
        $products = $this->store->search($filters);
        $lowStock = $this->store->getLowStock();
        return $this->view->render('product/list', [
            'baseUrl'  => $this->baseUrl,
            'products' => $products,
            'lowStock' => $lowStock,
            'filters'  => $filters,
        ]);
    }

    public function create()
    {
        return $this->view->render('product/create', [
            'baseUrl' => $this->baseUrl,
        ]);
    }

    public function store(Request $request)
    {
        $name = $request->request->get('name');
        if (empty($name)) {
            return $this->view->render('product/create', [
                'baseUrl' => $this->baseUrl,
                'error'   => 'Le nom du produit est obligatoire',
            ]);
        }
        $this->store->create([
            'name'         => $name,
            'description'  => $request->request->get('description'),
            'price'        => floatval($request->request->get('price')),
            'stock'        => intval($request->request->get('stock')),
            'seuil_alerte' => intval($request->request->get('seuil_alerte', 5)),
            'category'     => $request->request->get('category'),
            'origin'       => $request->request->get('origin'),
            'roast_level'  => $request->request->get('roast_level'),
            'weight_g'     => intval($request->request->get('weight_g', 0)),
            'tag'          => $request->request->get('tag', ''),
        ]);
        return new RedirectResponse($this->baseUrl . '/product');
    }

    public function edit($id)
    {
        $product = $this->store->getById($id);
        if (!$product) {
            return $this->view->render('product/error', [
                'baseUrl' => $this->baseUrl,
                'message' => 'Produit introuvable',
            ]);
        }
        return $this->view->render('product/edit', [
            'baseUrl' => $this->baseUrl,
            'product' => $product,
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = $this->store->update($id, [
            'name'         => $request->request->get('name'),
            'description'  => $request->request->get('description'),
            'price'        => floatval($request->request->get('price')),
            'stock'        => intval($request->request->get('stock')),
            'seuil_alerte' => intval($request->request->get('seuil_alerte', 5)),
            'category'     => $request->request->get('category'),
            'origin'       => $request->request->get('origin'),
            'roast_level'  => $request->request->get('roast_level'),
            'weight_g'     => intval($request->request->get('weight_g', 0)),
            'tag'          => $request->request->get('tag', ''),
        ]);
        if (!$product) {
            return $this->view->render('product/error', [
                'baseUrl' => $this->baseUrl,
                'message' => 'Produit introuvable',
            ]);
        }
        return new RedirectResponse($this->baseUrl . '/product');
    }

    public function delete($id)
    {
        $this->store->delete($id);
        return new RedirectResponse($this->baseUrl . '/product');
    }
}