<?php
require 'vendor/autoload.php'; // Include autoload-ul Composer

try {
    $client = new MongoDB\Client("mongodb://127.0.0.1:27017");
    $database = $client->selectDatabase('amitdb');
    echo "Conexiunea la MongoDB a fost realizată cu succes!";
} catch (Exception $e) {
    echo "Eroare la conectarea la MongoDB: " . $e->getMessage();
}
?>
