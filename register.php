<?php
require 'vendor/autoload.php'; // Include autoload-ul Composer

$client = new MongoDB\Client("mongodb://127.0.0.1:27017");
$database = $client->selectDatabase('amitdb');
$collection = $database->selectCollection('users');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $user = $collection->findOne(['username' => $username]);

    if ($user) {
        echo "Username-ul există deja!";
    } else {
        $collection->insertOne([
            'username' => $username,
            'password' => $password
        ]);
        echo "Înregistrarea a fost realizată cu succes!";
    }
}
?>
