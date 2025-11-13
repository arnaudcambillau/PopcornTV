<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isConnected = isset($_SESSION['user_id']);
?>

<ul>
    <li><a href="acceuil.php">Accueil</a></li>
    <li><a href="films.php">Tous les films</a></li>
    
    <?php if ($isConnected): ?>
        <li><a href="admin.php">ajouter un film</a></li>
        <li><a href="logout.php">Se déconnecter</a></li>
    <?php else: ?>
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="connexion.php">Connexion</a></li>
    <?php endif; ?>
</ul>

