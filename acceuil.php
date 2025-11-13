<?php
require_once 'config.php';

//je recupere les 5 derniers film
$sql = "SELECT id, title, urlphoto FROM film ORDER BY id DESC LIMIT 5";
$films = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - PopcornTV 🍿</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'menu.php'; ?>

<h1>Bienvenue sur PopcornTV 🍿</h1>
<img src="image/PopcornTV.png" alt="logo PopcornTV" width="200">
<p>Chaque film est une aventure ! Prépare ton popcorn et laisse-toi emporter !</p>

<hr>

<h2>Derniers Films Ajoutés</h2>

<?php if ($films): ?>
    <ul>
    <?php foreach ($films as $film): ?>
        <li>
            <h3><?= strtoupper(htmlspecialchars($film['title'])) ?></h3>
            <?php if ($film['urlphoto']): ?>
                <img src="<?= htmlspecialchars($film['urlphoto']) ?>" alt="<?= htmlspecialchars($film['title']) ?>" width="400">
            <?php else: ?>
                <p>[Pas d'image]</p>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun film ajouté pour le moment.</p>
<?php endif; ?>

</body>
</html>
