<?php
session_start();

unset($_SESSION['login']);
unset($_SESSION['password']);

echo '<script>window.location = "'. "login.php" .'";</script>';
?>

