<?php
require 'vendor/autoload.php'; // Include autoload-ul Composer

function getMongoDBConnection() {
    $client = new MongoDB\Client("mongodb://127.0.0.1:27017");
    return $client->selectDatabase('amitdb');
}
?>
