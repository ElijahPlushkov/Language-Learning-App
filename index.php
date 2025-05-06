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

<body class="bg-light">
<?php
include 'header.php';
require_once __DIR__.'/boot.php';

$user = null;
if (check_auth()) {
    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `user_id` = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <?php if ($user) : ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <h1 class="card-title mb-4">Greetings, <?=htmlspecialchars($user['username'])?>!</h1>
                        <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                            <a href="create_deck.php" class="btn btn-dark me-md-2">Decks</a>
                            <form method="post" action="do_logout.php">
                                <button type="submit" class="btn btn-primary">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

            <?php else : ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Registration</h1>

                        <?php flash(); ?>

                        <form method="post" action="do_register.php">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                                <br>


                                <a class="btn btn-outline-primary" href="login.php">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>