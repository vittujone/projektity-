<?php
include 'db.php';
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["role"]!="admin") header("Location: login.php");

$id = $_GET['id'] ?? null;
if($id){
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $password = $_POST["password"] ?? null;

    if($id){
        if($password){
            $pass_hash = password_hash($password,PASSWORD_DEFAULT);
            $stmt=$pdo->prepare("UPDATE users SET name=?,email=?,role=?,password=? WHERE id=?");
            $stmt->execute([$name,$email,$role,$pass_hash,$id]);
        } else {
            $stmt=$pdo->prepare("UPDATE users SET name=?,email=?,role=? WHERE id=?");
            $stmt->execute([$name,$email,$role,$id]);
        }
    } else {
        $pass_hash = password_hash($password,PASSWORD_DEFAULT);
        $stmt=$pdo->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
        $stmt->execute([$name,$email,$pass_hash,$role]);
    }
    header("Location: users.php");
    exit;
}
?>
<link rel="stylesheet" href="style.css">
<h2><?= $id?"Muokkaa käyttäjää":"Lisää käyttäjä" ?></h2>
<form method="post">
<input type="text" name="name" placeholder="Nimi" value="<?= $user['name']??'' ?>" required><br>
<input type="email" name="email" placeholder="Email" value="<?= $user['email']??'' ?>" required><br>
<select name="role">
<option value="user" <?= ($user['role']??'')=='user'?'selected':'' ?>>Käyttäjä</option>
<option value="admin" <?= ($user['role']??'')=='admin'?'selected':'' ?>>Admin</option>
</select><br>
<input type="password" name="password" placeholder="Salasana (vain muuttaessa)"><br>
<button type="submit"><?= $id?"Tallenna":"Lisää" ?></button>
</form>
<a href="users.php">Takaisin</a>
<p> hi </p>