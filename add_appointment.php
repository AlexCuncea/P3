<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

require 'vendor/autoload.php';

use MongoDB\Client as Mongo;

$mongo = new Mongo("mongodb://db:27017");
$collection = $mongo->test->appointments;

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $description = $_POST['description'];

    if (!empty($date) && !empty($description)) {
        $collection->insertOne([
            'email' => $email,
            'date' => $date,
            'description' => $description,
        ]);
        header('Location: my_appointments.php');
        exit();
    } else {
        echo 'Te rugăm să completezi toate câmpurile.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Appointment</title>
</head>
<body>
    <h1>Add Appointment</h1>
    <form method="post" action="add_appointment.php">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        <br>
        <input type="submit" value="Add">
    </form>
    <a href="my_appointments.php">Back to Appointments</a>
</body>
</html>
