<?php
try {
$mysqlClient = new PDO(
    'mysql:host=localhost;dbname=jo;charset=utf8',
    'root',
    ''
);
}catch(PDOexception $e){
    die($e->getMessage());
}
?>