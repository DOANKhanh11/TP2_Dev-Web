<?php
namespace Models;

use Models\DataStoreInterface;

class ProductPdoDataStore implements DataStoreInterface
{
    private $pdo;
    private $table;

    public function __construct($table = 'products')
    {
        $this->table = $table;
        $config      = require __DIR__ . '/../config/db.php';
        $dbConfig    = $config['database'];

        $hostParts = explode(':', $dbConfig['host']);
        $host      = $hostParts[0];
        $port      = $hostParts[1] ?? '3306';

        $dsn     = "mysql:host={$host};port={$port};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new \PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);
        $this->initTable();
    }

    private function initTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS `{$this->table}` (
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

        foreach ([
            'seuil_alerte' => 'INT DEFAULT 5',
            'category'     => 'VARCHAR(100) DEFAULT NULL',
            'origin'       => 'VARCHAR(100) DEFAULT NULL',
            'roast_level'  => 'VARCHAR(50) DEFAULT NULL',
            'weight_g'     => 'INT DEFAULT NULL',
            'tag'          => "VARCHAR(20) DEFAULT ''",
        ] as $col => $def) {
            try {
                $this->pdo->exec("ALTER TABLE `{$this->table}` ADD COLUMN `{$col}` {$def}");
            } catch (\Exception $e) {}
        }
    }

    public function getAll()
    {
        $stmt  = $this->pdo->query("SELECT * FROM `{$this->table}` ORDER BY created_at DESC");
        $items = [];
        foreach ($stmt->fetchAll() as $row) $items[$row['id']] = $row;
        return $items;
    }

    public function search(array $f) //Récupérer les filtres
    {
        $where = []; $params = [];
        if (!empty($f['name']))     { $where[] = 'name LIKE ?';  $params[] = '%'.$f['name'].'%'; }
        if (!empty($f['category'])) { $where[] = 'category = ?'; $params[] = $f['category']; }
        if (!empty($f['origin']))   { $where[] = 'origin = ?';   $params[] = $f['origin']; }
        if (!empty($f['tag']))      { $where[] = 'tag = ?';      $params[] = $f['tag']; }
        if (isset($f['price_min']) && $f['price_min'] !== '') { $where[] = 'price >= ?'; $params[] = floatval($f['price_min']); }
        if (isset($f['price_max']) && $f['price_max'] !== '') { $where[] = 'price <= ?'; $params[] = floatval($f['price_max']); }

        $sql = "SELECT * FROM `{$this->table}`";
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY created_at DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $items = [];
        foreach ($stmt->fetchAll() as $row) $items[$row['id']] = $row;
        return $items;
    }

    public function getLowStock(): array
    {
        return $this->pdo->query(
            "SELECT * FROM `{$this->table}` WHERE stock <= seuil_alerte ORDER BY stock ASC"
        )->fetchAll();
    }

    public function hasStock(string $id, int $qty): bool
    {
        $stmt = $this->pdo->prepare("SELECT stock FROM `{$this->table}` WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row && $row['stock'] >= $qty;
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `{$this->table}` WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create($data)
    {
        $id = uniqid(); $now = date('Y-m-d H:i:s');
        $this->pdo->prepare("
            INSERT INTO `{$this->table}`
                (id,name,description,price,stock,seuil_alerte,category,origin,roast_level,weight_g,tag,created_at)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
        ")->execute([
            $id,
            $data['name']         ?? '',
            $data['description']  ?? '',
            $data['price']        ?? 0,
            $data['stock']        ?? 0,
            $data['seuil_alerte'] ?? 5,
            $data['category']     ?? null,
            $data['origin']       ?? null,
            $data['roast_level']  ?? null,
            $data['weight_g']     ?? null,
            $data['tag']          ?? '',
            $now,
        ]);
        return $this->getById($id);
    }

    public function update($id, $data): array
    {
        $e = $this->getById($id);
        if (!$e) return [];
        $now = date('Y-m-d H:i:s');
        $this->pdo->prepare("
            UPDATE `{$this->table}`
            SET name=?,description=?,price=?,stock=?,seuil_alerte=?,
                category=?,origin=?,roast_level=?,weight_g=?,tag=?,updated_at=?
            WHERE id=?
        ")->execute([
            $data['name']         ?? $e['name'],
            $data['description']  ?? $e['description'],
            $data['price']        ?? $e['price'],
            $data['stock']        ?? $e['stock'],
            $data['seuil_alerte'] ?? $e['seuil_alerte'],
            $data['category']     ?? $e['category'],
            $data['origin']       ?? $e['origin'],
            $data['roast_level']  ?? $e['roast_level'],
            $data['weight_g']     ?? $e['weight_g'],
            $data['tag']          ?? $e['tag'],
            $now, $id,
        ]);
        return $this->getById($id);
    }

    public function delete(string $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM `{$this->table}` WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}