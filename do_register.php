<?php

require_once __DIR__.'/boot.php';

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `username` = :username");
$stmt->execute(['username' => $_POST['username']]);
if ($stmt->rowCount() > 0) {
    flash('this name is already taken.');
    header('Location: login.php');
    die;
}

$stmt = pdo()->prepare("INSERT INTO `users` (`username`, `password`) VALUES (:username, :password)");
$stmt->execute([
    'username' => $_POST['username'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
]);

header('Location: login.php');