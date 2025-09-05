<?php
include 'navbar.php';
include 'db.php';
session_start();
if(!isset($_SESSION["user_id"])) header("Location: login.php");

$id = $_SESSION["user_id"];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"] ?? null;

    if($password){
        $pass_hash = password_hash($password,PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, password=? WHERE id=?");
        $stmt->execute([$name, $email, $pass_hash, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET name=?, email=? WHERE id=?");
        $stmt->execute([$name, $email, $id]);
    }

    header("Location: settings.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Omat asetukset</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Omat asetukset</h2>

<form method="post">
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
    <input type="password" name="password" placeholder="Uusi salasana (valinnainen)"><br>
    <button type="submit">Tallenna</button>
</form>

<br>
<!-- Kirjaudu ulos -linkki -->
<a href="logout.php" onclick="return confirm('Haluatko varmasti kirjautua ulos?')">🔒 Kirjaudu ulos</a>
<br><br>
<a href="events.php">Takaisin</a>

</body>
</html>
