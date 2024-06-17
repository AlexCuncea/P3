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

$id = new MongoDB\BSON\ObjectId($_GET['id']);
$image = $collection->findOne(['_id' => $id]);

if ($image) {
    header("Content-Type: " . $image['type']);
    echo $image['data']->getData();
} else {
    echo "Imaginea nu a fost găsită.";
}
?>
