<?php

//session_start();

require_once 'boot.php';

if (!isset($_SESSION['user_id'])) {
    die("unauthorized");
}

if (!check_auth()) {
    header('Location: login.php');
    die;
}
$pdo = new PDO('mysql:dbname=flashcard_app; host=127.0.0.1', 'root', '');

$userId = $_SESSION['user_id'];
$deckName = $_POST['deck_name'];

if (isset($_POST['create-deck'])) {
    $sql = ("INSERT INTO `decks` (`user_id`, `deck_name`) VALUE (?,?)");
    $query = $pdo->prepare($sql);
    $query->execute([$userId, $deckName]);
}

$sql = $pdo->prepare("SELECT * FROM `decks` WHERE user_id = ?");
$sql->execute([$userId]);
$decks = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Deck</title>
    <!-- boostrap css link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awsome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <!--custom styles-->
    <link rel="stylesheet" href="styles.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</head>

<body>

<h1 class="h1">My Decks</h1>
<button class="btn btn-info add-new-deck" onclick="addNewDeck()">+ Add New Deck</button><br>

<form class="deck-form d-none" method="POST">
    <input type="text" class="deck-name-input" placeholder="deck name" name="deck_name">
    <button type="submit" class="create-deck" name="create-deck">Create Deck</button>
</form>

<div id="decksDisplay">
        <?php foreach($decks as $deck): ?>
        <div class="deck" id="<?= htmlspecialchars($deck['deck_id']) ?>">
            <button class="deck-toggle deck-name btn btn-warning"><?= htmlspecialchars($deck['deck_name']) ?></button>
            <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal<?=$deck['deck_id']?>">
                Edit Deck</button>
            <button class="delete-deck btn btn-dark btn-sm"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal<?=$deck['deck_id']?>" name="delete_deck">Delete Deck</button>
            <div class="deck-content">
                <button type="submit"
                        class="btn btn-primary add-new-card btn-lg"
                        data-deck-id="<?= $deck['deck_id'] ?>"
                data-bs-toggle="modal"
                data-bs-target="#addCard">+ Add New Card</button>

                <div class="card-display" id="cardsForDeck<?= $deck['deck_id']?>">
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM cards WHERE deck_id = ?");
                    $stmt->execute([$deck['deck_id']]);
                    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (empty($cards)) : ?>

                    <div class="alert alert-info mt-2">No cards in this deck yet.</div>

                    <?php else : ?>

                    <?php foreach ($cards as $card) : ?>
                            <div class="card mb-2" id="card-<?= $card['card_id'] ?>">
                                <div class="card-body">
                                    <div class="card-front">
                                        <p><?= htmlspecialchars($card['front_text']) ?></p>
                                        <button class="show-answer btn btn-sm btn-primary">Show Answer</button>
                                    </div>
                                    <div class="card-back d-none">
                                        <p><?= htmlspecialchars($card['back_text']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php include 'edit_deck.php'; include 'delete_deck.php'; endforeach; ?>
                </div>

<div class="modal fade" id="addCard" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="add_card.php">
                <input type="hidden" name="deck_id" id="deckId">
                <div class="modal-header">
                    <h5 class="modal-title">Add Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="card-question-input" placeholder="Question" name="front_text">
                        <input type="text" class="card-answer-input" placeholder="Answer" name="back_text">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add-card" class="btn btn-primary">+ Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.add-new-card').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('deckId').value = btn.dataset.deckId;
        });
    });
</script>

<script src="createDeck.js"></script>
</body>

</html>
