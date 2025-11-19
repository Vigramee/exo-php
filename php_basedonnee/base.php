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
$query = $mysqlClient->prepare("select * from jo.`100`;");
$query->execute();

$data = $query->fetchAll();
var_dump($data);

$mysqlClient = null;
$dbh = null;
?>