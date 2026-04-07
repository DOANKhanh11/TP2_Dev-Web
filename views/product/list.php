<?php
ob_start();
$prefix = $baseUrl.'/product';
?>
    <br>
    <h1>Liste des Produits</h1>

    <?php if (isset($_GET['error'])): ?>
        <div class="error">
            <?php if ($_GET['error'] === 'insufficient_stock'): ?>
                Stock insuffisant ! Quantité disponible : <?= htmlspecialchars($_GET['available'] ?? 0) ?>
            <?php elseif ($_GET['error'] === 'product_not_found'): ?>
                Produit introuvable.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="success" style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            <?php if ($_GET['success'] === 'product_added'): ?>
                Produit ajouté au panier avec succès!
            <?php endif; ?>
        </div>
    <?php endif; ?>

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
            <th>Quantité</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <?php $lowStock = ($product['stock'] ?? 0) <= 5 && ($product['stock'] ?? 0) > 0; ?>
            <tr<?= $lowStock ? ' class="low-stock"' : '' ?>>
                <td title="<?= htmlspecialchars($product['name']) ?>">
                    <?= htmlspecialchars(mb_strimwidth($product['name'], 0, 30, '...')) ?>
                    <?php if ($lowStock): ?><span class="stock-warning"> ⚠️ Stock faible</span><?php endif; ?>
                </td>
                <td title="<?= htmlspecialchars($product['description']) ?>">
                    <?= htmlspecialchars(mb_strimwidth($product['description'], 0, 30, '...')) ?>
                </td>
                <td><?= number_format($product['price'] ?? 0, 2) ?> €</td>
                <td<?= $lowStock ? ' class="stock-low"' : '' ?>>
                    <?= htmlspecialchars($product['stock'] ?? 0) ?>
                    <?php if ($lowStock): ?><small>(faible)</small><?php endif; ?>
                </td>
                <td><?= htmlspecialchars($product['created_at'] ?? '') ?></td>
                <td>
                    <?php if (($product['stock'] ?? 0) > 0): ?>
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" style="width: 60px;" form="cart_form_<?= $product['id'] ?>">
                    <?php else: ?>
                    <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= $prefix ?>/<?= $product['id'] ?>/edit" class="btn btn-sm">Modifier</a>
                    <?php if (($product['stock'] ?? 0) > 0): ?>
                    <form method="POST" action="<?= $baseUrl ?>/cart/add/<?= $product['id'] ?>" style="display: inline;" id="cart_form_<?= $product['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-success">Ajouter</button>
                    </form>
                    <?php else: ?>
                    <span class="text-muted">Rupture de stock</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $content = ob_get_clean(); include __DIR__.'/../layout.php'; ?>