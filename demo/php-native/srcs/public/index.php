<?php
$serverVars = [
    'HTTP_HOST' => $_SERVER['HTTP_HOST'] ?? 'N/A',
    'HOSTNAME' => $_SERVER['HOSTNAME'] ?? 'N/A',
    'SERVER_NAME' => $_SERVER['SERVER_NAME'] ?? 'N/A',
    'SERVER_PROTOCOL' => $_SERVER['SERVER_PROTOCOL'] ?? 'N/A',
];

$requestVars = [
    'X-Forwarded-Host' => $_SERVER['HTTP_X_FORWARDED_HOST'] ?? 'N/A',
    'X-Forwarded-For' => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? 'N/A',
    'User-Agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'N/A',
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Hello world</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>

<div class="container">
    
    <h1>🚀 PHP 8 + Nginx + Docker</h1>

    <div class="grid">

        <div class="card">
            <h2><a href="/variables/server">Variables du serveur</a></h2>
            <table>
                <?php foreach ($serverVars as $k => $v): ?>
                    <tr>
                        <td><?= htmlspecialchars($k) ?></td>
                        <td><?= htmlspecialchars($v) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="card">
            <h2><a href="/variables/client">Variables de requête</a></h2>
            <table>
                <?php foreach ($requestVars as $k => $v): ?>
                    <tr>
                        <td><?= htmlspecialchars($k) ?></td>
                        <td><?= htmlspecialchars($v) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </div>

    <div class="image-container">
        <a href="/assets"><img src="/assets" alt="Asset"></a>
    </div>

    <footer>
        PHP 8 + Nginx + Docker — Accès aux environnements
    </footer>

</div>

</body>
</html>
