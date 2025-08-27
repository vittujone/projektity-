<?php
include 'db.php';

if($_SERVER["REQUEST_METHOD"]=="POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
    $stmt->execute([$name,$email,$password]);
    header("Location: login.php");
    exit;
}
?>
<link rel="stylesheet" href="style.css">
<h2>Rekisteröidy</h2>
<form method="post">
<input type="text" name="name" placeholder="Nimi" required><br>
<input type="email" name="email" placeholder="Sähköposti" required><br>
<input type="password" name="password" placeholder="Salasana" required><br>
<button type="submit">Rekisteröidy</button>
</form>
<a href="login.php">Kirjaudu</a>
