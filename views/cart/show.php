<?php
ob_start();
$prefix = $baseUrl . '/cart';
?>
    <br>
    <h1>Votre Panier</h1>

    <?php if (isset($_GET['error'])): ?>
        <div class="error">
            <?php if ($_GET['error'] === 'insufficient_stock'): ?>
                Stock insuffisant ! Quantité disponible : <?= htmlspecialchars($_GET['available'] ?? 0) ?>
            <?php elseif ($_GET['error'] === 'product_not_found'): ?>
                Produit introuvable.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($quantityAdjusted) && $quantityAdjusted): ?>
        <div style="background: #e7f3ff; color: #0056b3; padding: 12px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #0056b3;">
            ℹ️ <strong>Mise à jour de votre panier</strong> : La quantité d'un ou plusieurs produits a été ajustée suite à une baisse du stock disponible.
        </div>
    <?php endif; ?>

    <div class="actions" style="margin-bottom: 1em;">
        <a href="<?= $baseUrl ?>/product" class="btn btn-success">Continuer mes achats</a>
    </div>

<?php if (empty($cart['items'])): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $grandTotal = 0;

        foreach ($cart['items'] as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= number_format($item['price'], 2) ?> €</td>
            <td>
                <form method="POST" action="<?= $baseUrl ?>/cart/update/<?= $item['product_id'] ?>" style="display: inline;">
                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="0" style="width: 60px;">
                    <button type="submit" class="btn btn-sm">Mettre à jour</button>
                </form>
            </td>
            <td><?= number_format($item['line_total'], 2) ?> €</td>
            <td>
                <form method="POST" action="<?= $baseUrl ?>/cart/remove/<?= $item['product_id'] ?>" style="display: inline;">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Retirer ce produit du panier ?')">Retirer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>

        </tbody>
        <tfoot>
        <tr>
            <th colspan="4">Total Panier</th>
            <th><?= number_format($cart['total'], 2) ?> €</th>
        </tr>
        </tfoot>
    </table>
<?php endif; ?>

<?php $content = ob_get_clean(); include __DIR__.'/../layout.php'; ?>
