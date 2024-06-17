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
    $id = new MongoDB\BSON\ObjectId($_POST['id']);
    $title = $_POST['title'];
    $date = $_POST['date'];
    $collection->updateOne(
        ['_id' => $id, 'username' => $_SESSION['username']],
        ['$set' => ['title' => $title, 'date' => $date]]
    );
    header("Location: my_appointments.php");
    exit();
}

$id = new MongoDB\BSON\ObjectId($_GET['id']);
$appointment = $collection->findOne(['_id' => $id, 'username' => $_SESSION['username']]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editare Programare</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Editare Programare</h1>
        <form action="edit_appointment.php" method="post">
            <input type="hidden" name="id" value="<?= $appointment['_id'] ?>">
            <div class="form-group">
                <label for="title">Titlu:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($appointment['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Dată:</label>
                <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($appointment['date']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvează Modificările</button>
        </form>
    </div>
</body>
</html>
