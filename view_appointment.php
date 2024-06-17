<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

require 'vendor/autoload.php';

use MongoDB\Client as Mongo;

$mongo = new Mongo("mongodb://db:27017");
$appointmentsCollection = $mongo->test->appointments;

$email = $_SESSION['email'];
$appointment_id = $_GET['id'];

// Selectează programarea specificată
$appointment = $appointmentsCollection->findOne([
    '_id' => new MongoDB\BSON\ObjectId($appointment_id),
    'email' => $email
]);

if (!$appointment) {
    echo 'Programarea nu a fost găsită.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Appointment</title>
</head>
<body>
    <h1>View Appointment</h1>
    <p><strong>Date:</strong> <?php echo htmlspecialchars($appointment['date']); ?></p>
    <p><strong>Time:</strong> <?php echo htmlspecialchars($appointment['time']); ?></p>
    <p><strong>Details:</strong> <?php echo htmlspecialchars($appointment['details']); ?></p>
    <a href="my_appointments.php">Back to Appointments</a>
</body>
</html>
