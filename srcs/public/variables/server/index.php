<?php
$allServerVars = $_SERVER;
ksort($allServerVars);
$filteredServerVars = array_filter($allServerVars, function($key) {
    return !(str_starts_with($key, 'HTTP_') || str_starts_with($key, 'REQUEST_'));
}, ARRAY_FILTER_USE_KEY);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Variables du serveur</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>

<div class="container">

    <h1>📦 Variables du serveur</h1>

    <p style="text-align:center;">
        <a href="/">⬅ Retour à l'accueil</a>
    </p>

    <div class="card single-column">
        <table>
			<tr>
				<th>Clé</th>
				<th>Valeur</th>
			</tr>
            <?php foreach ($filteredServerVars as $key => $value): ?>
                <tr>
                    <td><?= htmlspecialchars($key) ?></td>
                    <td><?= htmlspecialchars(is_array($value) ? json_encode($value) : $value) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <footer>
        PHP 8 + Nginx + Docker — Variables du serveur
    </footer>

</div>

</body>
</html>
