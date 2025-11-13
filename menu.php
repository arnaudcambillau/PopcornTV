<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isConnected = isset($_SESSION['user_id']);
?>

<nav>
    <div class="logo">PopcornTV</div>

    <ul>
        <li><a href="acceuil.php">Accueil</a></li>
        <li><a href="films.php">Tous les films</a></li>

        <?php if ($isConnected): ?>
            <li><a href="admin.php">Ajouter un film</a></li>
            <li><a href="logout.php">Se déconnecter</a></li>
        <?php else: ?>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        <?php endif; ?>
    </ul>

    <div class="burger">
        <div></div>
        <div></div>
        <div></div>
    </div>
</nav>

<script>
const burger = document.querySelector('.burger');
const nav = document.querySelector('nav ul');

burger.addEventListener('click', () => {
    nav.classList.toggle('active');
    burger.classList.toggle('active');
});
</script>
