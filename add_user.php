<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = getMongoDBConnection();
    $collection = $db->users;

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $result = $collection->insertOne([
        'username' => $username,
        'password' => $password
    ]);

    if ($result->getInsertedCount() == 1) {
        echo "User added successfully.";
    } else {
        echo "Error adding user.";
    }
}
?>
