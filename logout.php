<?php
session_start();
session_destroy();
setcookie("username", "", time() - 3600, "/"); // Stergem cookie-ul
header("Location: index.php");
exit();
?>
