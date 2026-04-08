<?php
ob_start();
$prefix     = $baseUrl . '/product';
$filters    = $filters    ?? [];
$categories = $categories ?? [];
$origins    = $origins    ?? [];
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
=======

<h1>☕ Liste des Cafés Vietnamiens</h1>

>>>>>>> Stashed changes
<!-- Q2 : Formulaire de recherche -->
<form method="GET" action="<?= $prefix ?>/search"
      style="background:#f8f9fa;border:1px solid #dee2e6;border-radius:8px;padding:16px;margin-bottom:20px">
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:12px">
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" value="<?= htmlspecialchars($filters['name'] ?? '') ?>" placeholder="Rechercher...">
        </div>
        <div class="form-group">
            <label>Catégorie</label>
            <select name="category">
                <option value="">Toutes</option>
                <?php foreach (['Grains entiers','Café moulu','Instantané','Spécialité','Accessoires'] as $cat): ?>
                    <option value="<?= $cat ?>" <?= ($filters['category'] ?? '') === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Origine</label>
            <select name="origin">
                <option value="">Toutes</option>
                <?php foreach (['Đà Lạt','Đắk Lắk','Đắk Nông','Gia Lai','Kon Tum','Khánh Hòa','Hà Nội','TP.HCM','Đà Nẵng','Đồng Nai','Hội An','Bình Định','Việt Nam'] as $orig): ?>
                    <option value="<?= $orig ?>" <?= ($filters['origin'] ?? '') === $orig ? 'selected' : '' ?>><?= $orig ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tag</label>
            <select name="tag">
                <option value="">Tous</option>
                <option value="Nouveau" <?= ($filters['tag'] ?? '') === 'Nouveau' ? 'selected' : '' ?>>Nouveau</option>
                <option value="Promo"   <?= ($filters['tag'] ?? '') === 'Promo'   ? 'selected' : '' ?>>Promo</option>
            </select>
        </div>
        <div class="form-group">
            <label>Prix min</label>
            <input type="number" name="price_min" value="<?= htmlspecialchars($filters['price_min'] ?? '') ?>" placeholder="0" step="1000">
        </div>
        <div class="form-group">
            <label>Prix max</label>
            <input type="number" name="price_max" value="<?= htmlspecialchars($filters['price_max'] ?? '') ?>" placeholder="1000000" step="1000">
        </div>
<<<<<<< Updated upstream
=======
>>>>>>> a2a6c0c68821726fcc7ee093f8e7470435425688
>>>>>>> Stashed changes
    </div>
    <div class="actions">
        <button type="submit" class="btn btn-primary">Rechercher</button>
        <a href="<?= $prefix ?>" class="btn">Réinitialiser</a>
        <a href="<?= $prefix . '/create?baseUrl=' . $baseUrl ?>" class="btn btn-success" style="margin-left:auto">+ Nouveau produit</a>
    </div>
</form>

<?php if (empty($products)): ?>
    <p class="empty">Aucun produit trouvé.</p>
<?php else: ?>
    <p style="color:#6c757d;font-size:13px;margin-bottom:8px"><?= count($products) ?> produit(s)</p>
    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Catégorie</th>
            <th>Origine</th>
            <th>Torréfaction</th>
            <th>Tag</th>
            <th>Prix (₫)</th>
            <th>Stock</th>
<<<<<<< Updated upstream
            <th>Date création</th>
=======
<<<<<<< HEAD
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
            <?php $lowStock = ($product['stock'] ?? 0) <= 5 && ($product['stock'] ?? 0) > 0; ?>
            <tr<?= $lowStock ? ' class="low-stock"' : '' ?>>
                <td title="<?= htmlspecialchars($product['name']) ?>">
<<<<<<< Updated upstream
                    <strong><?= htmlspecialchars(mb_strimwidth($product['name'], 0, 30, '...')) ?></strong>
=======
<<<<<<< HEAD
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
<<<<<<< Updated upstream
                <td><?= htmlspecialchars($product['category'] ?? '-') ?></td>
                <td><?= htmlspecialchars($product['origin'] ?? '-') ?></td>
                <td><?= htmlspecialchars($product['roast_level'] ?? '-') ?></td>
                <td>
=======
<<<<<<< HEAD
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
