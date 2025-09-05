<?php
include 'navbar.php';
include 'db.php';
session_start();
if(!isset($_SESSION["user_id"])) header("Location: login.php");

$events = $pdo->query("SELECT * FROM events ORDER BY date,time")->fetchAll();
?>
<link rel="stylesheet" href="style.css">
<h2>Tapahtumat</h2>
<a href="event_edit.php">➕ Lisää tapahtuma</a> | <a href="logout.php">Kirjaudu ulos</a>
<table border="1">
<tr><th>Nimi</th><th>Kuvaus</th><th>Päivä</th><th>Aika</th><th>Toiminnot</th></tr>
<?php foreach($events as $e): ?>
<tr>
<td><?= htmlspecialchars($e["name"]) ?></td>
<td><?= htmlspecialchars($e["description"]) ?></td>
<td><?= $e["date"] ?></td>
<td><?= $e["time"] ?></td>
<td>
<a href="event_edit.php?id=<?= $e['id'] ?>">Muokkaa</a> |
<a href="event_delete.php?id=<?= $e['id'] ?>" onclick="return confirm('Poistetaanko?')">Poista</a>
</td>
</tr>
<?php endforeach; ?>
</table>
