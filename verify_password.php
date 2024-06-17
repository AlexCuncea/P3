<?php
require 'vendor/autoload.php';

use MongoDB\Client as Mongo;

try {
    $mongo = new Mongo("mongodb://db:27017");
    echo "Conectare la MongoDB...<br>";
    $collection = $mongo->test->users;

    $email = 'ana@yahoo.com';  // Email-ul pe care vrei să-l verifici
    $password = 'Parola4';  // Parola nehash-ată

    $user = $collection->findOne(['email' => strtolower($email)]);

    if ($user) {
        echo 'Email găsit: ' . $user['email'] . '<br>';
        echo 'Parola hash-ată din baza de date: ' . $user['password'] . '<br>';

        if (password_verify($password, $user['password'])) {
            echo 'Parola este corectă!';
        } else {
            echo 'Parolă incorectă!';
        }
    } else {
        echo 'Emailul nu a fost găsit!';
    }
} catch (Exception $e) {
    echo 'Eroare la conectarea la MongoDB: ' . $e->getMessage();
}
?>
