<?php
include 'db.php';
session_start();
if(!isset($_SESSION["user_id"])) header("Location: login.php");

$id=$_GET['id']??null;
if($id){
    $stmt=$pdo->prepare("DELETE FROM events WHERE id=?");
    $stmt->execute([$id]);
}
header("Location: events.php");
exit;
?>
