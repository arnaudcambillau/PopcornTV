<?php
require_once 'config.php';

// je vérifie si un id est passé en URL
if (!isset($_GET['id'])) {
    die("Film non trouvé.");
}

$id = (int) $_GET['id'];

// je recupère le film dans la base
$stmt = $pdo->prepare("SELECT title, description, urlvideo, urlphoto FROM film WHERE id = ?");
$stmt->execute([$id]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$film) {
    die("Film non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($film['title']) ?> - PopcornTV 🍿</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Conteneur vidéo fixe avec contrôles */
        .video-wrapper {
            width: 800px;      /* largeur fixe */
            max-width: 90%;    /* responsive pour mobile */
            height: 450px;     /* hauteur fixe */
            margin: 20px auto;
            border: 2px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .video-wrapper iframe {
            width: 100%;
            height: 100%;
        }

        @media (max-width: 600px) {
            .video-wrapper {
                height: 250px;
            }
        }
    </style>
</head>
<body>
<?php include 'menu.php'; ?>

<h1><?= htmlspecialchars($film['title']) ?></h1>

<p><?= htmlspecialchars($film['description']) ?></p>

<?php if ($film['urlvideo']): ?>
    <div class="video-wrapper">
        <?= $film['urlvideo'] // L'iframe doit contenir controls pour YouTube ou lecteur HTML5 ?>
    </div>
<?php else: ?>
    <p>Pas de vidéo disponible pour ce film.</p>
<?php endif; ?>

</body>
</html>
