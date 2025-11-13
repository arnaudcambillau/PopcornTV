<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $urlvideo = trim($_POST['urlvideo']);
    $urlphoto = '';

    // je limite de 255 caractères sur la description
    if (strlen($description) > 255) {
        $error = "La description ne doit pas dépasser 255 caractères.";
    } elseif (empty($title) || empty($description)) {
        $error = "Le titre et la description sont obligatoires.";
    } else {
        // Upload photo si elle est presente
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $newName = 'uploads/film_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $newName)) {
                    $urlphoto = $newName;
                } else {
                    $error = "Erreur upload image.";
                }
            } else {
                $error = "Format d'image non autorisé.";
            }
        }

        // j'ajoute le film si pas d'erreur
        if (!$error) {
            $stmt = $pdo->prepare("INSERT INTO film (title, description, urlphoto, urlvideo) VALUES (?,?,?,?)");
            $stmt->execute([$title, $description, $urlphoto, $urlvideo]);
            $success = "Film ajouté !";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin - Ajouter film</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'menu.php'; ?>

<h1>Ajouter un film</h1>

<?php if ($error) echo "<p style='color:red'>$error</p>"; ?>
<?php if ($success) echo "<p style='color:green'>$success</p>"; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Titre* :</label><br>
    <input type="text" name="title" required maxlength="100"><br> 
    <label>Description* (max 255 caractères) :</label><br>
    <textarea name="description" required maxlength="255"></textarea><br>
    <label>Photo :</label><br>
    <input type="file" name="photo" accept="image/*"><br>
    <label>Code iframe vidéo :</label><br>
    <textarea name="urlvideo" placeholder='<iframe src="..."></iframe>'></textarea><br>
    <button type="submit">Ajouter</button>
</form>

</body>
</html>
