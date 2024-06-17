<?php
$password = 'Parola4'; // Parola nehash-ată

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

echo 'Parola hash-ată: ' . $hashed_password . '<br>';

// Verifică hash-ul
if (password_verify($password, $hashed_password)) {
    echo 'Parola verificată cu succes!';
} else {
    echo 'Eroare la verificarea parolei!';
}
?>
