<?php
ob_start();
$prefix = $baseUrl . '/cart';
?>
    <br>
    <h1>Votre Panier</h1>
    <br>

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
