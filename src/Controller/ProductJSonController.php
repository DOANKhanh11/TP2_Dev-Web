<?php

namespace Controllers;

use Models\ProductJsonDataStore;

// Contrôleur pour gérer les produits avec un stockage Json --à ignorer car on utilise pdo
class ProductJsonController extends AbstractProductController
{
    protected function initStore()
    {
        $this->store = new ProductJsonDataStore();
        $params = require __DIR__ . '/../config/params.php';
        $this->baseUrl = $params['json_baseUrl'];;
    }
}