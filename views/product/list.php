<?php
ob_start();
$prefix = $baseUrl.'/product';
?>
    <br>
    <h1>Liste des Produits</h1>

    <div class="actions">
        <a href="<?= $prefix."/create?baseUrl=$baseUrl"?>" class="btn btn-primary">Nouveau Produit</a>
    </div>

<?php if (empty($products)): ?>
    <p>Aucun produit trouvé.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Date de création</th>
            <th>Ajouter au panier</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td title="<?= htmlspecialchars($product['name']) ?>">
                    <?= htmlspecialchars(mb_strimwidth($product['name'], 0, 30, '...')) ?>
                </td>
                <td title="<?= htmlspecialchars($product['description']) ?>">
                    <?= htmlspecialchars(mb_strimwidth($product['description'], 0, 30, '...')) ?>
                </td>
                <td><?= number_format($product['price'] ?? 0, 2) ?> €</td>
                <td><?= htmlspecialchars($product['stock'] ?? 0) ?></td>
                <td><?= htmlspecialchars($product['created_at'] ?? '') ?></td>
                <td>
                    <?php if (($product['stock'] ?? 0) > 0): ?>
                    <form method="POST" action="<?= $baseUrl ?>/cart/add/<?= $product['id'] ?>" style="display: inline;">
                        <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" style="width: 60px;">
                        <button type="submit" class="btn btn-sm btn-success">Ajouter</button>
                    </form>
                    <?php else: ?>
                    <span class="text-muted">Rupture de stock</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= $prefix ?>/<?= $product['id'] ?>/edit" class="btn btn-sm">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $content = ob_get_clean(); include __DIR__.'/../layout.php'; ?>