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

    <!-- Filtres de recherche -->
<?php $filters = $filters ?? []; ?>
<form method="GET" action="<?= $prefix ?>/search">
    <div class="form-group" style="display:flex;gap:10px;flex-wrap:wrap;margin:16px 0">
        <input type="text" name="name" placeholder="Nom..."
               value="<?= htmlspecialchars($filters['name'] ?? '') ?>"
               style="width:150px">

        <select name="category">
            <option value="">Toutes catégories</option>
            <?php foreach (['Grains entiers','Café moulu','Instantané','Spécialité','Accessoires'] as $cat): ?>
                <option value="<?= $cat ?>" <?= ($filters['category'] ?? '') === $cat ? 'selected' : '' ?>>
                    <?= $cat ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="origin">
            <option value="">Toutes origines</option>
            <?php foreach (['Đà Lạt','Đắk Lắk','Đắk Nông','Gia Lai','Kon Tum','Khánh Hòa','Hà Nội','TP.HCM','Đà Nẵng','Đồng Nai','Hội An','Bình Định','Việt Nam'] as $orig): ?>
                <option value="<?= $orig ?>" <?= ($filters['origin'] ?? '') === $orig ? 'selected' : '' ?>>
                    <?= $orig ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="tag">
            <option value="">Tous tags</option>
            <option value="Nouveau" <?= ($filters['tag'] ?? '') === 'Nouveau' ? 'selected' : '' ?>>Nouveau</option>
            <option value="Promo"   <?= ($filters['tag'] ?? '') === 'Promo'   ? 'selected' : '' ?>>Promo</option>
        </select>

        <input type="number" name="price_min" placeholder="Prix min"
               value="<?= htmlspecialchars($filters['price_min'] ?? '') ?>"
               style="width:100px" step="1000">

        <input type="number" name="price_max" placeholder="Prix max"
               value="<?= htmlspecialchars($filters['price_max'] ?? '') ?>"
               style="width:100px" step="1000">

        <button type="submit" class="btn btn-primary">🔍 Rechercher</button>
        <a href="<?= $prefix ?>" class="btn">Réinitialiser</a>
    </div>
</form>

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
                    <form method="POST" action="<?= $prefix ?>/<?= $product['id'] ?>/delete" style="display:inline">
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $content = ob_get_clean(); include __DIR__.'/../layout.php'; ?>