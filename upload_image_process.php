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
$collection = $database->selectCollection('imagini');

if (isset($_FILES['fileToUpload'])) {
    $image = file_get_contents($_FILES['fileToUpload']['tmp_name']);
    $document = [
        'username' => $_SESSION['username'],
        'name' => $_FILES['fileToUpload']['name'],
        'type' => $_FILES['fileToUpload']['type'],
        'data' => new MongoDB\BSON\Binary($image, MongoDB\BSON\Binary::TYPE_GENERIC)
    ];
    $collection->insertOne($document);
    echo "Imaginea a fost încărcată cu succes!";
} else {
    echo "Nu s-a selectat nicio imagine.";
}
?>
