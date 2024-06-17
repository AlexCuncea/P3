<?php
session_start();
if (!isset($_SESSION['username']) && isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
}
if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit();
}

require 'vendor/autoload.php'; // Include autoload-ul Composer

$client = new MongoDB\Client("mongodb://127.0.0.1:27017");
$database = $client->selectDatabase('amitdb');
$collection = $database->selectCollection('appointments');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $collection->insertOne([
        'username' => $_SESSION['username'],
        'title' => $title,
        'date' => $date
    ]);
}

$appoinments = $collection->find(['username' => $_SESSION['username']]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Programările Mele</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Programările Mele</h1>
        <form action="my_appointments.php" method="post">
            <div class="form-group">
                <label for="title">Titlu:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="date">Dată:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <button type="submit" class="btn btn-primary">Adaugă Programare</button>
        </form>
        <h2>Programări</h2>
        <ul class="list-group">
            <?php foreach ($appoinments as $appointment) : ?>
                <li class="list-group-item">
                    <?= htmlspecialchars($appointment['title']) ?> - <?= htmlspecialchars($appointment['date']) ?>
                    <a href="edit_appointment.php?id=<?= $appointment['_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_appointment.php?id=<?= $appointment['_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
