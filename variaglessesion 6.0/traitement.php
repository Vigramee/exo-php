<?php
session_start();
$_SESSION["username"] = $_POST["username"];

echo "<h1>Bonjour " . $_SESSION["username"] . "</h1>";
?>

<a href="index.php">
    <button onclick = "unset($_SESSION['username']);">supprimer</button>
</a>