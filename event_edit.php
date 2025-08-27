<?php
include 'db.php';
session_start();
if(!isset($_SESSION["user_id"])) header("Location: login.php");

$id = $_GET['id'] ?? null;
if($id){
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id=?");
    $stmt->execute([$id]);
    $event = $stmt->fetch();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name=$_POST["name"];
    $desc=$_POST["description"];
    $date=$_POST["date"];
    $time=$_POST["time"];

    if($id){
        $stmt=$pdo->prepare("UPDATE events SET name=?,description=?,date=?,time=? WHERE id=?");
        $stmt->execute([$name,$desc,$date,$time,$id]);
    } else {
        $stmt=$pdo->prepare("INSERT INTO events (name,description,date,time) VALUES (?,?,?,?)");
        $stmt->execute([$name,$desc,$date,$time]);
    }
    header("Location: events.php");
    exit;
}
?>
<link rel="stylesheet" href="style.css">
<h2><?= $id?"Muokkaa tapahtumaa":"Lisää tapahtuma" ?></h2>
<form method="post">
<input type="text" name="name" placeholder="Nimi" value="<?= $event['name']??'' ?>" required><br>
<textarea name="description" placeholder="Kuvaus"><?= $event['description']??'' ?></textarea><br>
<input type="date" name="date" value="<?= $event['date']??'' ?>" required><br>
<input type="time" name="time" value="<?= $event['time']??'' ?>" required><br>
<button type="submit"><?= $id?"Tallenna":"Lisää" ?></button>
</form>
<a href="events.php">Takaisin</a>
