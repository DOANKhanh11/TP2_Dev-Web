<?php
ob_start();
$prefix = $_GET["baseUrl"].'/product';
?>

    <h1>Créer un Produit</h1>

<?php if (isset($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

    <form method="POST" action="<?= $prefix."/store"?>">
        <div class="form-group">
            <label for="name">Nom du produit *</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

        <div class="form-group">
            <label for="category">Catégorie</label>
            <select id="category" name="category" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:5px;font-size:14px">
                <option value="">-- Choisir --</option>
                <option value="Grains entiers">Grains entiers</option>
                <option value="Café moulu">Café moulu</option>
                <option value="Instantané">Instantané</option>
                <option value="Spécialité">Spécialité</option>
                <option value="Accessoires">Accessoires</option>
            </select>
        </div>

        <div class="form-group">
            <label for="origin">Origine</label>
            <select id="origin" name="origin" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:5px;font-size:14px">
                <option value="">-- Choisir --</option>
                <option value="Đà Lạt">Đà Lạt</option>
                <option value="Đắk Lắk">Đắk Lắk</option>
                <option value="Đắk Nông">Đắk Nông</option>
                <option value="Gia Lai">Gia Lai</option>
                <option value="Kon Tum">Kon Tum</option>
                <option value="Khánh Hòa">Khánh Hòa</option>
                <option value="Hà Nội">Hà Nội</option>
                <option value="TP.HCM">TP.HCM</option>
                <option value="Đà Nẵng">Đà Nẵng</option>
                <option value="Đồng Nai">Đồng Nai</option>
                <option value="Hội An">Hội An</option>
                <option value="Bình Định">Bình Định</option>
                <option value="Việt Nam">Việt Nam</option>
            </select>
        </div>

        <div class="form-group">
            <label for="roast_level">Torréfaction</label>
            <select id="roast_level" name="roast_level" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:5px;font-size:14px">
                <option value="">-- Choisir --</option>
                <option value="Light">Légère</option>
                <option value="Medium-Light">Légère-Moyenne</option>
                <option value="Medium">Moyenne</option>
                <option value="Medium-Dark">Moyenne-Foncée</option>
                <option value="Dark">Foncée</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tag">Tag</label>
            <select id="tag" name="tag" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:5px;font-size:14px">
                <option value="">Aucun</option>
                <option value="Nouveau">Nouveau</option>
                <option value="Promo">Promo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Prix (€)</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="0">
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" min="0" value="0">
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-success">Créer</button>
            <a href="<?= $baseUrl ?>" class="btn">Annuler</a>
        </div>
    </form>

<?php $content = ob_get_clean(); include __DIR__.'/../layout.php'; ?>