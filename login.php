<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password,$user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];
        header("Location: events.php");
        exit;
    } else {
        $error = "Virheellinen tunnus tai salasana!";
    }
}
?>
<link rel="stylesheet" href="style.css">
<h2>Kirjaudu</h2>
<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
<form method="post">
<input type="email" name="email" placeholder="Sähköposti" required><br>
<input type="password" name="password" placeholder="Salasana" required><br>
<button type="submit">Kirjaudu</button>
</form>
<a href="register.php">Rekisteröidy</a>
