<?php
require 'vendor/autoload.php';

use MongoDB\Client as Mongo;

$mongo = new Mongo("mongodb://db:27017");
$collection = $mongo->test->users;

$email = 'ana@yahoo.com';
$password = 'Parola4';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$collection->insertOne([
    'email' => strtolower($email),
    'password' => $hashed_password
]);

echo 'Utilizator de test inserat cu succes.';
?>
