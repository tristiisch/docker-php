<?php

session_start(); 

$requestVars = [
    'GET'     => $_GET,
    'POST'    => $_POST,
    'REQUEST' => $_REQUEST,
    'COOKIE'  => $_COOKIE,
    'FILES'   => $_FILES,
    'SESSION' => $_SESSION,
];

$headers = getallheaders();
ksort($headers);

$rawInput = file_get_contents('php://input');
if ($rawInput) {
    $requestVars['RAW_INPUT'] = $rawInput;
}

foreach ($requestVars as $section => $vars) {
    if (is_array($vars)) {
        ksort($vars);
        $requestVars[$section] = $vars;
    }
}

$serverVars = $_SERVER;
ksort($serverVars);
foreach ($serverVars as $key => $value) {
    if (str_starts_with($key, 'REQUEST_')) {
        $requestVars['SERVER'][$key] = $value;
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Variables de requête</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>

<div class="container">

    <h1>📦 Variables de requête</h1>

    <p style="text-align:center;">
        <a href="/">⬅ Retour à l'accueil</a>
    </p>

	<div class="card single-column">
        <h2>Headers HTTP</h2>
        <table>
                <tr>
                    <th>Clé</th>
                    <th>Valeur</th>
                </tr>
            <?php foreach ($headers as $key => $value): ?>
                <tr>
                    <td><?= htmlspecialchars($key) ?></td>
                    <td><?= htmlspecialchars(is_array($value) ? json_encode($value) : $value) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <?php foreach ($requestVars as $section => $vars): ?>
	<div class="card single-column">
		<h2><?= htmlspecialchars($section) ?></h2>
		<table>
			<tr>
				<th>Clé</th>
				<th>Valeur</th>
			</tr>
			<?php if (is_array($vars)): ?>
				<?php foreach ($vars as $key => $value): ?>
					<tr>
						<td><?= htmlspecialchars($key) ?></td>
						<td><?= htmlspecialchars(is_array($value) ? json_encode($value) : $value) ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td>RAW_INPUT</td>
					<td><?= htmlspecialchars($vars) ?></td>
				</tr>
			<?php endif; ?>
		</table>
	</div>
    <?php endforeach; ?>

    <footer>
        PHP 8 + Nginx + Docker — Variables de requête
    </footer>

</div>

</body>
</html>
