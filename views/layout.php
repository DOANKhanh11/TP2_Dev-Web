<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vietnam coffee shop</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f1f0ee; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .site-title { text-align: center; font-size: 2.6rem; font-weight: 800; color: #4d331f; margin-bottom: 25px; letter-spacing: 1px; }
        h1 { color: #333; margin-bottom: 30px; }
        .btn { display: inline-block; padding: 10px 20px; background: #dcf0c3; color: #2c3e50; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; font-size: 14px; }
        .btn:hover { background: #b5d8a0; }
        .btn-danger { background: #dd9e59; }
        .btn-danger:hover { background: #c37d46; }
        .btn-success { background: #ece7d1; color: #4d331f; }
        .btn-success:hover { background: #d8d0b8; }
        .btn-warning {
            background: #f0d8a1;
            color: #4d331f;
        }
        .btn-warning:hover {
            background: #e1c986;
        }
        .btn-turquoise {
            background: #4d331f;
            color: #fff;
        }
        .btn-turquoise:hover {
            background: #3f2a1a;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: 600; color: #495057; }
        tr:hover { background: #f8f9fa; }
        tr.low-stock { background: #fff3cd; }
        tr.low-stock:hover { background: #ffeaa7; }
        .stock-low { color: #856404; font-weight: bold; }
        .stock-warning { color: #856404; font-size: 0.8em; margin-left: 5px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: 500; color: #495057; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        input:focus, textarea:focus { outline: none; border-color: #dcf0c3; }
        .actions { display: flex; gap: 10px; }
        .error { background: #f5e0d4; color: #6f3f21; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .empty { text-align: center; padding: 40px; color: #6c757d;}
        nav {
            background: #a47251;
            padding: 12px 20px;
        }

        nav a {
            color: #ecf0f1;
            text-decoration: none;
            margin-right: 20px;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="site-title">Vietnam coffee shop</div>
        <nav>
            <a href="<?= $baseUrl ?>/product">Produits</a>
            <a href="<?= $baseUrl ?>/cart">Voir mon panier</a>
        </nav>

        <?php echo $content; ?>
    </div>
</body>
</html>

