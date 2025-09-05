<?php
include 'navbar.php';
include 'db.php';
session_start();
if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Lisää uusi ilmoittautuminen
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user_id = $_POST["user_id"];
    $event_id = $_POST["event_id"];
    $stmt = $pdo->prepare("INSERT INTO enrollments (user_id, event_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $event_id]);
    header("Location: enrollments.php");
    exit;
}

// Hae ilmoittautumiset
$enrollments = $pdo->query("
    SELECT e.id AS en_id, u.name AS user_name, ev.name AS event_name
    FROM enrollments e
    JOIN users u ON e.user_id = u.id
    JOIN events ev ON e.event_id = ev.id
    ORDER BY ev.date
")->fetchAll();

// Käyttäjät ja tapahtumat dropdown-valikkoihin
$users = $pdo->query("SELECT * FROM users ORDER BY name")->fetchAll();
$events = $pdo->query("SELECT * FROM events ORDER BY date")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8" />
    <title>Ilmoittautumiset</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<h2>Ilmoittautumiset</h2>

<form method="post">
    <select name="user_id" required>
        <option value="">Valitse käyttäjä</option>
        <?php foreach($users as $u): ?>
            <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <select name="event_id" required>
        <option value="">Valitse tapahtuma</option>
        <?php foreach($events as $ev): ?>
            <option value="<?= $ev['id'] ?>"><?= htmlspecialchars($ev['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Lisää ilmoittautuminen</button>
</form>

<table border="1">
    <tr>
        <th>Käyttäjä</th>
        <th>Tapahtuma</th>
        <th>Toiminnot</th>
    </tr>
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

</body>
</html>
