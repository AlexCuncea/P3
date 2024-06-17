<?php
session_start();
require 'vendor/autoload.php'; // Include autoload-ul Composer

$client = new MongoDB\Client("mongodb://127.0.0.1:27017");
$database = $client->selectDatabase('amitdb');
$collection = $database->selectCollection('users');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $collection->findOne(['username' => $username]);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        setcookie("username", $username, time() + (86400 * 30), "/"); // Cookie valabil 30 de zile
        header("Location: my_appointments.php");
        exit();
    } else {
        echo "Autentificare eșuată!";
    }
}
?>
