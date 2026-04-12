<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Faker\Factory as FakerFactory;

$faker = FakerFactory::create('fr_FR');

// Vérification de sécurité : script exécutable uniquement en ligne de commande
// --> éviter qu'on puisse le récupérer via un autre moyen et faire n'importe quoi avec
if (php_sapi_name() !== 'cli') {
    die("Ce script ne peut être exécuté qu'en ligne de commande.\n");
}

// Vérif de sécurité : confirmation manuelle
echo "Attention : Ce script va créer des tables (si elles n'existent pas) et insérer des données fictives de test.\n";
echo "Assurez-vous d'être en environnement de développement et que la base de données est sauvegardée.\n";
echo "Continuer ? (oui/non) : ";
$handle = fopen("php://stdin", "r");
$line = trim(fgets($handle));
if ($line !== 'oui') {
    die("Script annulé.\n");
}

// Connexion bdd
$config = require __DIR__ . '/config/db.php';
$dbConfig = $config['database'];

$hostParts = explode(':', $dbConfig['host']);
$host = $hostParts[0];
$port = $hostParts[1] ?? '3306';

$dsn = "mysql:host={$host};port={$port};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
$options = [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new \PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);

// Vérif que les tables existent
$pdo->exec("
    CREATE TABLE IF NOT EXISTS products (
        id           VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci PRIMARY KEY,
        name         VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
        description  TEXT         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
        price        DECIMAL(10,2) DEFAULT 0,
        stock        INT           DEFAULT 0,
        seuil_alerte INT           DEFAULT 5,
        category     VARCHAR(100)  DEFAULT NULL,
        origin       VARCHAR(100)  DEFAULT NULL,
        roast_level  VARCHAR(50)   DEFAULT NULL,
        weight_g     INT           DEFAULT NULL,
        tag          VARCHAR(20)   DEFAULT '',
        created_at   DATETIME,
        updated_at   DATETIME
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS carts (
        id VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci PRIMARY KEY,
        created_at DATETIME,
        updated_at DATETIME
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS cart_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cart_id VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
        product_id VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
        quantity INT DEFAULT 1,
        UNIQUE(cart_id, product_id),
        INDEX idx_cart (cart_id),
        INDEX idx_product (product_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

// Création produits
echo "Création des produits\n";
$productIds = [];
for ($i = 0; $i < 50; $i++) {
    $productId = $faker->uuid();
    $productData = [
        'id' => $productId,
        'name' => $faker->words(3, true),
        'description' => $faker->paragraph(),
        'price' => $faker->randomFloat(2, 5, 50),
        'stock' => $faker->numberBetween(0, 100),
        'seuil_alerte' => $faker->numberBetween(1, 10),
        'category' => $faker->randomElement(['Arabica', 'Robusta', 'Blend']),
        'origin' => $faker->country(),
        'roast_level' => $faker->randomElement(['Light', 'Medium', 'Dark']),
        'weight_g' => $faker->randomElement([250, 500, 1000]),
        'tag' => $faker->randomElement(['', 'nouveau', 'promo']),
        'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
    ];

    // Insertion produits
    $stmt = $pdo->prepare("
        INSERT INTO products (id, name, description, price, stock, seuil_alerte, category, origin, roast_level, weight_g, tag, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute(array_values($productData));

    $productIds[] = $productId;
    echo "Product $i: {$productData['name']}\n";
}

// Création paniers
echo "Création du panier par défaut\n";
$cartId = 'default';
$cartData = [
    'id' => $cartId,
    'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
    'updated_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
];

// Insertion panier
$stmt = $pdo->prepare("
    INSERT INTO carts (id, created_at, updated_at)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE updated_at = VALUES(updated_at)
");
$stmt->execute(array_values($cartData));

// Ajouts randoms de produits dans le panier
$numItems = $faker->numberBetween(10, 20);
$selectedProducts = $faker->randomElements($productIds, $numItems, false);

foreach ($selectedProducts as $productId) {
    $quantity = $faker->numberBetween(1, 3);
    $stmt = $pdo->prepare("
        INSERT INTO cart_items (cart_id, product_id, quantity)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
    ");
    $stmt->execute([$cartId, $productId, $quantity]);
}

echo "Panier créé avec $numItems produits\n";

echo "Population terminée\n";