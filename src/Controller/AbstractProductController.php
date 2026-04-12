<?php
namespace Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Util\View;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Formatter\LineFormatter;

abstract class AbstractProductController
{
    protected $store;
    protected $view;
    protected $baseUrl;
    protected $logger;

    public function __construct()
    {
        $this->view = new View();
        $this->logger = new Logger('produits');
        $handler = new StreamHandler(__DIR__ . '/../../logs/app.log', Level::Debug);
        $formatter = new \Monolog\Formatter\LineFormatter(null, null, true, true);
        $handler->setFormatter($formatter);
        $this->logger->pushHandler($handler);
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
        $this->logger->info('Produit ajouté', ['nom' => $name]);
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
        $this->logger->info('Produit modifié', ['id' => $id, 'nom' => $request->request->get('name')]);
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
        $product = $this->store->getById($id);
        $this->logger->info('Produit supprimé', ['id' => $id, 'nom' => $product['name'] ?? 'inconnu']);
        return new RedirectResponse($this->baseUrl . '/product');
    }
}