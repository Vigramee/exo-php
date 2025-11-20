<?php
try {
$dbh =  new PDO(
    'mysql:host=localhost;dbname=jo;charset=utf8',
    'root',
    ''
);
}
catch(PDOexception $e){
    die($e->getMessage());
}


if (isset($_POST['register'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '') {
        echo "<b>Le champ username est vide</b>";
    } elseif ($password === '') {
        echo "<b>Le champ password est vide</b>";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sth = $dbh->prepare("INSERT INTO `user` (`username`, `password`) VALUES (:username, :password)");
        $sth->execute([
            'username' => $username,
            'password' => $hash,
        ]);
        echo "<b>Votre inscription est valide</b>";
    }
}

if(isset($_POST['connect'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $stmt = $dbh ->prepare("select * from jo.`100`;");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($username === '') {
        echo "<b>Le champ username  est vide</b>";
    } elseif ($password === '') {
        echo "<b>Le champ password est vide</b>";
    } else {
        $stmt = $dbh->prepare("SELECT * FROM `user` WHERE `username` = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "<b>Le username n’existe pas</b>";
        } elseif (!password_verify($password, $user['password'])) {
            echo "<b>Le mot de passe est invalide</b>";
        } else {
            $_SESSION['username'] = $username;
            echo "<b>Bien connecté</b>";
        }
    }
}

?>