<?php
include 'db.php';
session_start();
if(!isset($_SESSION["user_id"])) header("Location: login.php");

// Lisää uusi ilmoittautuminen
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $user_id = $_POST["user_id"];
    $event_id = $_POST["event_id"];
    $stmt = $pdo->prepare("INSERT INTO enrollments (user_id,event_id) VALUES (?,?)");
    $stmt->execute([$user_id,$event_id]);
    header("Location: enrollments.php");
    exit;
}

// Hae ilmoittautumiset
$enrollments = $pdo->query(
    "SELECT e.id,enrollments.id AS en_id,u.name AS user_name,ev.name AS event_name 
     FROM enrollments 
     JOIN users u ON enrollments.user_id=u.id 
     JOIN events ev ON enrollments.event_id=ev.id
     ORDER BY ev.date"
)->fetchAll();

// Käyttäjät ja tapahtumat dropdown
$users = $pdo->query("SELECT * FROM users")->fetchAll();
$events = $pdo->query("SELECT * FROM events ORDER BY date")->fetchAll();
?>
<link rel="stylesheet" href="style.css">
<h2>Ilmoittautumiset</h2>
<form method="post">
<select name="user_id" required>
<option value="">Valitse käyttäjä</option>
<?php foreach($users as $u) echo "<option value='{$u['id']}'>{$u['name']}</option>"; ?>
</select>
<select name="event_id" required>
<option value="">Valitse tapahtuma</option>
<?php foreach($events as $ev) echo "<option value='{$ev['id']}'>{$ev['name']}</option>"; ?>
</select>
<button type="submit">Lisää ilmoittautuminen</button>
</form>

<table border="1">
<tr><th>Käyttäjä</th><th>Tapahtuma</th><th>Toiminnot</th></tr>
<?php foreach($enrollments as $en): ?>
<tr>
<td><?= htmlspecialchars($en['user_name']) ?></td>
<td><?= htmlspecialchars($en['event_name']) ?></td>
<td>
<a href="enrollment_delete.php?id=<?= $en['en_id'] ?>" onclick="return confirm('Poistetaanko?')">Poista</a>
</td>
</tr>
<?php endforeach; ?>
</table>
<a href="events.php">Takaisin</a>
