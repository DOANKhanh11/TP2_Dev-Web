<?php
namespace Models;

use Models\DataStoreInterface;

class CartPdoDataStore implements DataStoreInterface
{
    private $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/db.php';
        $dbConfig = $config['database'];

        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false
        ];

        $this->pdo = new \PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);
        $this->initTables();
    }

    private function initTables()
    {
        $this->pdo->exec("
        CREATE TABLE IF NOT EXISTS cart_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id VARCHAR(255)
                CHARACTER SET utf8mb4
                COLLATE utf8mb4_unicode_ci,
            quantity INT DEFAULT 1,
            UNIQUE(product_id),
            INDEX idx_product (product_id)
        )
        ENGINE=InnoDB
        DEFAULT CHARSET=utf8mb4
        COLLATE=utf8mb4_unicode_ci
    ");
    }

    /* ================= CART ================= */

    public function getAll()
    {
        return ['default' => $this->getById('default')];
    }

    public function getById($id)
    {
        if ($id !== 'default') {
            return null;
        }

        $stmt = $this->pdo->query("
        SELECT 
            ci.product_id,
            p.name,
            p.price,
            ci.quantity,
            (p.price * ci.quantity) AS line_total
        FROM cart_items ci
        JOIN products p ON p.id = ci.product_id
    ");
        $items = $stmt->fetchAll();

        $total = 0;
        foreach ($items as $item) {
            $total += $item['line_total'];
        }

        return [
            'id' => 'default',
            'items' => $items,
            'total' => $total
        ];
    }

    public function create(array $data = [], $customId = null)
    {
        // Avec un seul panier, on réinitialise simplement le contenu existant
        $this->pdo->exec("DELETE FROM cart_items");

        return $this->getById('default');
    }

    public function update(string $id, array $data): array|null
    {
        if ($id !== 'default') {
            return null;
        }

        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $this->addOrUpdateItem($id, $item['product_id'], $item['quantity']);
            }
        }

        return $this->getById('default');
    }

    public function delete(string $id): bool
    {
        if ($id !== 'default') {
            return false;
        }

        $stmt = $this->pdo->prepare("DELETE FROM cart_items");
        $stmt->execute();

        return true;
    }

    /* ================= ITEMS ================= */

    public function addItem(string $cartId, string $productId, int $quantity = 1): void
    {
        // Vérifier si le produit est déjà dans le panier
        $stmt = $this->pdo->prepare(
            "SELECT quantity FROM cart_items WHERE product_id = ?"
        );
        $stmt->execute([$productId]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Le produit existe → on incrémente la quantité
            $stmt = $this->pdo->prepare(
                "UPDATE cart_items
                 SET quantity = quantity + ?
                 WHERE product_id = ?"
            );
            $stmt->execute([$quantity, $productId]);
        } else {
            // Le produit n'existe pas → on l'ajoute
            $stmt = $this->pdo->prepare(
                "INSERT INTO cart_items (product_id, quantity)
                 VALUES (?, ?)"
            );
            $stmt->execute([$productId, $quantity]);
        }
    }

    public function addOrUpdateItem(string $cartId, string $productId, int $qty): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO cart_items (product_id, quantity)
             VALUES (?, ?)
             ON DUPLICATE KEY UPDATE quantity = ?"
        );
        $stmt->execute([$productId, $qty, $qty]);
    }

    public function removeItem(string $cartId, string $productId): void
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM cart_items WHERE product_id = ?"
        );
        $stmt->execute([$productId]);
    }
}
