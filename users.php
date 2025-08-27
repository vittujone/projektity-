<?php
include 'db.php';
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["role"]!="admin") header("Location: login.php");

$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>
<link rel="stylesheet" href="style.css">
<h2>Käyttäjät</h2>
<a href="user_edit.php">➕ Lisää käyttäjä</a>
<table border="1">
<tr><th>Nimi</th><th>Email</th><th>Rooli</th><th>Toiminnot</th></tr>
<?php foreach($users as $u): ?>
<tr>
<td><?= htmlspecialchars($u['name']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>
<td><?= $u['role'] ?></td>
<td>
<a href="user_edit.php?id=<?= $u['id'] ?>">Muokkaa</a> |
<a href="user_delete.php?id=<?= $u['id'] ?>" onclick="return confirm('Poistetaanko?')">Poista</a>
</td>
</tr>
<?php endforeach; ?>
</table>
<a href="events.php">Takaisin</a>
