<?php
require 'vendor/autoload.php'; // Asigură-te că autoload-ul Composer este inclus

function testMongoDBConnection() {
    try {
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $database = $client->selectDatabase('numele_bazei_de_date');
        echo "Conexiunea la MongoDB a fost realizată cu succes!";
    } catch (Exception $e) {
        echo "Eroare la conectarea la MongoDB: " . $e->getMessage();
    }
}

testMongoDBConnection();
?>
