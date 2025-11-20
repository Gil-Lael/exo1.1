<?php
session_start();
 
$host = 'localhost';
$dbName = 'football';
$user = 'root';
$password = 'L@elwifi2025';
 
try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
 
$message = "";
 
if (isset($_POST['register'])) {
    if (empty($_POST['username'])) {
        $message = "Le champ username de l'inscription est vide";
    } elseif (empty($_POST['password'])) {
        $message = "Le champ password de l'inscription est vide";
    } else {
        $stmt = $dbh->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(['username' => $_POST['username']]);
        
        if ($stmt->fetch()) {
            $message = "Ce nom d'utilisateur existe déjà";
        } else {
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $dbh->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
            $stmt->execute([
                'username' => $_POST['username'],
                'password' => $hash
            ]);
            $message = "Votre inscription est valide";
        }
    }
}
 
if (isset($_POST['connect'])) {
    if (empty($_POST['username'])) {
        $message = "Le champ username de la connexion est vide";
    } elseif (empty($_POST['password'])) {
        $message = "Le champ password de la connexion est vide";
    } else {
        $stmt = $dbh->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(['username' => $_POST['username']]);
        $userFound = $stmt->fetch(PDO::FETCH_ASSOC);
 
        if (!$userFound) {
            $message = "Le username n'existe pas dans la base de données";
        } else {
            if (password_verify($_POST['password'], $userFound['password'])) {
                $_SESSION['username'] = $userFound['username'];
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $message = "Le mot de passe est invalide";
            }
        }
    }
}
 
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP Login</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        h1 { margin-top: 30px; }
        form { margin-bottom: 20px; border: 1px solid #ccc; padding: 20px; width: 300px; }
        label { display: block; margin-top: 10px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 5px; margin-top: 5px; box-sizing: border-box; }
        input[type="submit"] { margin-top: 15px; padding: 5px 10px; }
        .message { padding: 15px; background: #ffdddd; border: 1px solid #ffcccc; color: #a00000; margin-bottom: 20px; }
    </style>
</head>
<body>
 
    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
 
    <?php if (isset($_SESSION['username'])): ?>
        
        <h1>Bonjour <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <a href="?logout=true">Se déconnecter</a>
 
    <?php else: ?>
 
        <h1>Inscription</h1>
        <form method="post" action="">
            <label>Username :</label>
            <input type="text" name="username">
            
            <label>Password :</label>
            <input type="password" name="password">
            
            <input type="submit" value="Valider" name="register">
        </form>
 
        <h1>Connection</h1>
        <form method="post" action="">
            <label>Username :</label>
            <input type="text" name="username">
            
            <label>Password :</label>
            <input type="password" name="password">
            
            <input type="submit" value="Valider" name="connect">
        </form>
 
    <?php endif; ?>
 
</body>
</html>