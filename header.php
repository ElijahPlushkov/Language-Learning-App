<?php
require_once 'boot.php';

if (check_auth()) {
    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `user_id` = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $userDisplay = htmlspecialchars($user['username']);
} else {
    $userDisplay = "Stranger";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Learning App</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Welcome, <?= $userDisplay ?>!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">My Decks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="create_deck.php">Create Deck</a>
                </li>
            </ul>

            <?php if (check_auth()) : ?>
                <form id="logOutForm" method="post" action="do_logout.php" class="d-none"></form>
                <button type="submit" form="logOutForm" class="btn btn-outline-light me-2">Logout</button>
            <?php endif; ?>

            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search decks" aria-label="Search">
                <button class="btn btn-light" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>