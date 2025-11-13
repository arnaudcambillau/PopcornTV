<?php
require_once 'config.php';
session_start();

$error = '';

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

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <p>
            <label>Login :</label><br>
            <input type="text" name="login" required>
        </p>
        <p>
            <label>Mot de passe :</label><br>
            <input type="password" name="password" required>
        </p>
        <p>
            <button type="submit">Se connecter</button>
        </p>
    </form>

    <p>Pas encore inscrit ? <a href="inscription.php">Créer un compte</a></p>
</body>
</html>
