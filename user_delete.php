<?php
include 'db.php';
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["role"]!="admin") header("Location: login.php");

$id = $_GET['id'] ?? null;
if($id){
    $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
    $stmt->execute([$id]);
}
header("Location: users.php");
exit;
?>
