<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Variables de requête</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <style>
        .center-image { width: 100%; }
    </style>
</head>

<body>

<div class="container">

    <h1>📦 Asset</h1>

    <p style="text-align:center;">
        <a href="/">⬅ Retour à l'accueil</a>
    </p>

    <div class="card single-column">
        <h2>Asset :</h2>
        <?php if (!empty($imageUrl)): ?>
            <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Centered Image" class="center-image">
        <?php else: ?>
            <p>Aucune image fournie</p>
        <?php endif; ?>
    </div>

    <footer>
        PHP 8 + Nginx + Docker — Asset
    </footer>

</div>

</body>
</html>
