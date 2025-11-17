<?php
require_once 'config.php';
session_start();

$error = '';
$success = '';

// Message success si inscriptions
if (isset($_GET['inscription']) && $_GET['inscription'] === 'success') {
    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    if (empty($login) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $sql = "SELECT id, login, password FROM user WHERE login = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            header('Location: acceuil.php');
            exit;
        } else {
            $error = "Login ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - PopcornTV 🍿</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'menu.php'; ?>

    <h1>Connexion - PopcornTV 🍿</h1>

    <?php if ($success): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <p>
            <label>Login :</label><br>
            <input type="text" name="login" placeholder="jean-luc" required>
        </p>
        <p>
            <!--     <label>Mot de passe :</label><br>
            <input type="password" name="password" placeholder="*****" id="pwd" required>

            <input type="checkbox" onclick="pwd.type = this.checked ? 'text' : 'password' "> -->

        <p style="position: relative;">
            <label>Mot de passe :</label><br>
            <input type="password" name="password" placeholder="*****" id="pwd" required style="padding-right: 45px;">
            <input type="checkbox" id="togglePwd" onclick="togglePasswordIcon()" style="display: none;">
            <label for="togglePwd" id="eyeLabel" style="cursor: pointer; position: absolute; right: 15px; bottom: 2px; z-index: 10;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.6; transition: opacity 0.3s;">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" fill="currentColor" />
                </svg>
            </label>
        </p>

        </p>
        <p>
            <button type="submit">Se connecter</button>
        </p>
    </form>

    <p>Pas encore inscrit ? <a href="inscription.php">Créer un compte</a></p>
</body>
</html>