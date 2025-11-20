<?php
session_start();
$_SESSION["username"] = $_POST["username"];

echo "<h1>Bonjour " . $_SESSION["username"] . "</h1>";

?>