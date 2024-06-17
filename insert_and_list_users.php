<?php
require 'vendor/autoload.php';

use MongoDB\Client as Mongo;

$mongo = new Mongo("mongodb://db:27017");
$collection = $mongo->test->users;

// Inserează un utilizator de test
$email = 'ana@yahoo.com';
$password = 'Parola4';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$collection->insertOne([
    'email' => strtolower($email),
    'password' => $hashed_password
]);

// Listează toți utilizatorii
$allUsers = $collection->find();
echo 'Utilizatori existenți:<br>';
foreach ($allUsers as $user) {
    echo 'Email: ' . $user['email'] . '<br>';
    echo 'Parola hash-ată: ' . $user['password'] . '<br>';
}
?>
