<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // verif champ vide
    if (empty($login) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } 
    // Verif mdp correct
    elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } 
    else {
        // Verif log existant
        $stmt = $pdo->prepare("SELECT id FROM user WHERE login = ?");
        $stmt->execute([$login]);
        
        if ($stmt->fetch()) {
            $error = "Ce login est déjà utilisé.";
        } else {
            // cree et crypter le mdp
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO user (login, password) VALUES (?, ?)");
            $stmt->execute([$login, $hashed_password]);
            
            // Redirection automatique vers la page de connexion
            header('Location: connexion.php?inscription=success');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - PopcornTV 🍿</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"/>
</head>
<body>
    <?php include 'menu.php'; ?>

    <main class="container">
        <h1>Inscription - PopcornTV 🍿</h1>

        <?php if ($error): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="login">Login :</label>
                <input type="text" id="login" name="login" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn-primary">S'inscrire</button>
        </form>

        <p class="text-center">
            Déjà inscrit ? <a href="connexion.php">Se connecter</a>
        </p>
    </main>
</body>
</html>