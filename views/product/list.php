<?php
ob_start();
?>
<<<<<<< HEAD
<<<<<<< Updated upstream

<h1>☕ Liste des Cafés Vietnamiens</h1>

=======
<<<<<<< HEAD
=======
>>>>>>> origin/gestion_stocks
    <br>
    <h1>Liste des Produits</h1>

    <div class="actions">
        <a href="<?= $prefix."/create?baseUrl=$baseUrl"?>" class="btn btn-primary">Nouveau Produit</a>
    </div>

<?php if (empty($products)): ?>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Stock</th>
            <th>Date de création</th>
            <th>Quantité</th>
<<<<<<< HEAD
=======
            <th>Date création</th>
>>>>>>> a2a6c0c68821726fcc7ee093f8e7470435425688
>>>>>>> Stashed changes
=======
>>>>>>> origin/gestion_stocks
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
                <td title="<?= htmlspecialchars($product['name']) ?>">
                    <?= htmlspecialchars(mb_strimwidth($product['name'], 0, 30, '...')) ?>
                    <?php if ($lowStock): ?><span class="stock-warning"> ⚠️ Stock faible</span><?php endif; ?>
<<<<<<< HEAD
=======
                    <strong><?= htmlspecialchars(mb_strimwidth($product['name'], 0, 30, '...')) ?></strong>
>>>>>>> a2a6c0c68821726fcc7ee093f8e7470435425688
>>>>>>> Stashed changes
=======
>>>>>>> origin/gestion_stocks
                </td>
                <td title="<?= htmlspecialchars($product['description'] ?? '') ?>">
                    <?= htmlspecialchars(mb_strimwidth($product['description'] ?? '', 0, 30, '...')) ?>
                </td>
                <td><?= number_format($product['price'] ?? 0, 2) ?> €</td>
                <td><?= htmlspecialchars($product['created_at'] ?? '') ?></td>
                <td>
                    <a href="<?= $prefix ?>/<?= $product['id'] ?>/edit" class="btn btn-sm">Modifier</a>
                    <?php if (($product['stock'] ?? 0) > 0): ?>
                    <form method="POST" action="<?= $baseUrl ?>/cart/add/<?= $product['id'] ?>" style="display: inline;" id="cart_form_<?= $product['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-success">Ajouter</button>
<<<<<<< HEAD
=======
                <td><?= htmlspecialchars($product['category'] ?? '-') ?></td>
                <td><?= htmlspecialchars($product['origin'] ?? '-') ?></td>
                <td><?= htmlspecialchars($product['roast_level'] ?? '-') ?></td>
                <td>
>>>>>>> Stashed changes
                    <?php if (!empty($product['tag'])): ?>
                        <span style="background:<?= $product['tag']==='Nouveau'?'#17a2b8':'#fd7e14' ?>;color:white;padding:2px 8px;border-radius:12px;font-size:11px;font-weight:600">
                            <?= htmlspecialchars($product['tag']) ?>
                        </span>
                    <?php else: echo '-'; endif; ?>
                </td>
                <td><?= number_format($product['price'] ?? 0, 0, ',', '.') ?> ₫</td>
                <td><?= htmlspecialchars($product['stock'] ?? 0) ?></td>
                <td style="font-size:12px"><?= htmlspecialchars(substr($product['created_at'] ?? '', 0, 10)) ?></td>
                <td>
                    <a href="<?= $prefix ?>/<?= $product['id'] ?>/edit" class="btn btn-sm btn-warning">Modifier</a>
                    <form method="POST" action="<?= $prefix ?>/<?= $product['id'] ?>/delete" style="display:inline">
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
<<<<<<< Updated upstream
=======
>>>>>>> a2a6c0c68821726fcc7ee093f8e7470435425688
>>>>>>> Stashed changes
=======
>>>>>>> origin/gestion_stocks
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
