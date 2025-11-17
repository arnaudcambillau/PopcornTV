<?php
require_once 'config.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if (empty($login) || empty($password) || empty($confirmPassword)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif ($password !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si le login existe déjà
        $sql = "SELECT id FROM user WHERE login = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login]);

        if ($stmt->fetch()) {
            $error = "Ce login est déjà utilisé.";
        } else {
            // Insérer le nouvel utilisateur
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (login, password) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$login, $hashedPassword])) {
                header('Location: connexion.php?inscription=success');
                exit;
            } else {
                $error = "Une erreur est survenue. Veuillez réessayer.";
            }
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
</head>

<body>
    <?php include 'menu.php'; ?>

    <h1>Inscription - PopcornTV 🍿</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <p>
            <label>Login :</label><br>
            <input type="text" name="login" placeholder="jean-luc" required>
        </p>
        
        <p style="position: relative;">
            <label>Mot de passe :</label><br>
            <input type="password" name="password" placeholder="*****" id="pwd" required style="padding-right: 45px;">
            <input type="checkbox" id="togglePwd" onclick="togglePasswordIcon()" style="display: none;">
            <label for="togglePwd" id="eyeLabel" style="cursor: pointer; position: absolute; right: 15px; bottom: 2px; z-index: 10;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.6; transition: opacity 0.3s;">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" fill="#8E8E93" />
                </svg>
            </label>
        </p>

        <p style="position: relative;">
            <label>Confirmer le mot de passe :</label><br>
            <input type="password" name="confirm_password" placeholder="*****" id="confirmPwd" required style="padding-right: 45px;">
            <input type="checkbox" id="toggleConfirmPwd" onclick="toggleConfirmPasswordIcon()" style="display: none;">
            <label for="toggleConfirmPwd" id="eyeConfirmLabel" style="cursor: pointer; position: absolute; right: 15px; bottom: 2px; z-index: 10;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.6; transition: opacity 0.3s;">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" fill="#8E8E93" />
                </svg>
            </label>
        </p>

        <p>
            <button type="submit">S'inscrire</button>
        </p>
    </form>

    <p>Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>

</body>
</html>