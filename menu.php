<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isConnected = isset($_SESSION['user_id']);
?>

<nav>
    <ul>
        <!-- Logo cliquable -->
        <li><a href="acceuil.php">PopcornTV 🍿</a></li>
        
        <!-- Menu central -->
        <li><a href="acceuil.php">Accueil</a></li>
        <li><a href="films.php">Tous les films</a></li>
        
        <?php if ($isConnected): ?>
            <li><a href="admin.php">Ajouter un film</a></li>
            <li><a href="logout.php">Se déconnecter</a></li>
        <?php else: ?>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        <?php endif; ?>
        
        <!-- Bouton dark mode -->
        <li>
            <button class="material-symbols-outlined" id="themeToggle" aria-label="Basculer le mode clair/sombre" aria-pressed="false">dark_mode</button>
        </li>
    </ul>
</nav>

<script src="dark_mode.js"></script>
