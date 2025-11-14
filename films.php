<?php
require_once 'config.php';
session_start();

$isAdmin = isset($_SESSION['user_id']); // connecté = admin

// j'autorise la suppression uniquement si admin
if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $idToDelete = (int) $_POST['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM film WHERE id = ?");
    $stmt->execute([$idToDelete]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// je récupère tous les films
$films = $pdo->query("SELECT id, title, description, urlphoto FROM film ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tous les films - PopcornTV 🍿</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"/>
</head>
<body>
<?php include 'menu.php'; ?>

<h1>Tous les films</h1>

<?php if ($films): ?>
    <ul>
    <?php foreach ($films as $film): ?>
        <li>
            <!-- TITRE CLIQUABLE VERS lecture.php -->
            <h3>
                <a href="lecture.php?id=<?= $film['id'] ?>">
                    <?= strtoupper(htmlspecialchars($film['title'])) ?>
                </a>
            </h3>

            <?php if ($film['urlphoto']): ?>
                <img src="<?= htmlspecialchars($film['urlphoto']) ?>" width="200" alt="<?= htmlspecialchars($film['title']) ?>">
            <?php endif; ?>

            <p><?= htmlspecialchars($film['description']) ?></p>

            <?php if ($isAdmin): ?>
            <form method="post" onsubmit="return confirm('Supprimer ce film ?');" style="display:inline;">
                <input type="hidden" name="delete_id" value="<?= $film['id'] ?>">
                <button type="submit">Supprimer</button>
            </form>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun film disponible.</p>
<?php endif; ?>

</body>
</html>
