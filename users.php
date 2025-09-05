<?php
session_start();
include 'db.php';
include 'navbar.php';

if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if($_SESSION["role"] !== "admin") {
    // Näytetään alert ja ohjataan takaisin etusivulle
    echo "<script>
            alert('Ei ole riittävät oikeudet.');
            window.location.href = 'events.php';
          </script>";
    exit;
}

$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8" />
    <title>Käyttäjät</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<h2>Käyttäjät</h2>
<a href="user_edit.php">➕ Lisää käyttäjä</a>
<table border="1">
<tr><th>Nimi</th><th>Email</th><th>Rooli</th><th>Toiminnot</th></tr>
<?php foreach($users as $u): ?>
<tr>
    <td><?= htmlspecialchars($u['name']) ?></td>
    <td><?= htmlspecialchars($u['email']) ?></td>
    <td><?= htmlspecialchars($u['role']) ?></td>
    <td>
        <a href="user_edit.php?id=<?= $u['id'] ?>">Muokkaa</a> |
        <a href="user_delete.php?id=<?= $u['id'] ?>" onclick="return confirm('Poistetaanko?')">Poista</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
<a href="events.php">Takaisin</a>

</body>
</html>
