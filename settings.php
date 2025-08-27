<?php
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
        $stmt=$pdo->prepare("UPDATE users SET name=?,email=?,password=? WHERE id=?");
        $stmt->execute([$name,$email,$pass_hash,$id]);
    } else {
        $stmt=$pdo->prepare("UPDATE users SET name=?,email=? WHERE id=?");
        $stmt->execute([$name,$email,$id]);
    }
    header("Location: settings.php");
    exit;
}
?>
<link rel="stylesheet" href="style.css">
<h2>Omat asetukset</h2>
<form method="post">
<input type="text" name="name" value="<?= $user['name'] ?>" required><br>
<input type="email" name="email" value="<?= $user['email'] ?>" required><br>
<input type="password" name="password" placeholder="Uusi salasana"><br>
<button type="submit">Tallenna</button>
</form>
<a href="events.php">Takaisin</a>
