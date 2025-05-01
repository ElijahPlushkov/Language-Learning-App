<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>authentication form demo</title>
    <!-- boostrap css link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
</head>

<body>

<?php

require_once __DIR__.'/boot.php';

if (check_auth()) {
    header('Location: index.php');
    die;
}
?>

<h1 class="mb-5">Login</h1>

<?php flash() ?>

<div class="container mt-3">
<form method="post" action="do_login.php">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Login</button>
        <a class="btn btn-outline-primary" href="index.php">Register</a>
    </div>
</form>
</div>

</body>
</html>
