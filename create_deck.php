<?php

//session_start();

require_once 'boot.php';

if (!isset($_SESSION['user_id'])) {
    exit;
}

if (!check_auth()) {
    header('Location: login.php');
    exit;
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <!-- Bootstrap JS Bundle -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</head>

<body class="bg-light">
<?php include 'header.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5">My Decks</h1>
        <button class="btn btn-info" onclick="addNewDeck()">
            <i class="fas fa-plus"></i> Add New Deck
        </button>
    </div>

    <form class="deck-form d-none card p-3 mb-4 bg-white shadow-sm" method="POST">
        <div class="input-group">
            <input type="text" class="form-control deck-name-input" placeholder="Deck name" name="deck_name">
            <button type="submit" class="btn btn-primary create-deck" name="create-deck">Create Deck</button>
        </div>
    </form>

    <div id="decksDisplay">
        <?php foreach($decks as $deck): ?>
            <div class="deck card mb-4 shadow-sm" id="<?= htmlspecialchars($deck['deck_id']) ?>">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0 deck-name"><?= htmlspecialchars($deck['deck_name']) ?></h2>
                        <div>
                            <button type="button" class="btn btn-sm btn-dark me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="">
                                <i class="fa-solid fa-book"></i> Revise
                            </button>
                            <button type="button" class="btn btn-sm btn-info me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="">
                                <i class="fa-solid fa-eye"></i> View
                            </button>
                            <button type="button" class="btn btn-sm btn-success me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal<?=$deck['deck_id']?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal<?=$deck['deck_id']?>"
                                    name="delete_deck">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-lg add-new-card"
                                data-deck-id="<?= $deck['deck_id'] ?>"
                                data-bs-toggle="modal"
                                data-bs-target="#addCard">
                            <i class="fas fa-plus"></i> Add New Card
                        </button>

                        <button type="button" class="btn btn-success btn-lg toggle-card-display"
                                data-deck-id="<?= $deck['deck_id'] ?>"
                        <i class="fa-solid fa-square-minus"></i> Hide Cards
                        </button>
                    </div>

                    <div class="card-display" id="cardsForDeck<?= $deck['deck_id']?>">
                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM cards WHERE deck_id = ?");
                        $stmt->execute([$deck['deck_id']]);
                        $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (empty($cards)) : ?>
                            <div class="alert alert-info">No cards in this deck yet.</div>
                        <?php else : ?>
                            <?php foreach ($cards as $card) : ?>
                                <div class="card mb-3" id="card-<?= $card['card_id'] ?>">
                                    <div class="card-body">
                                        <button type="button" class="btn btn-sm btn-success me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editCardModal<?=$card['card_id']?>">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger"
                                                type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteCardModal<?=$card['card_id']?>"
                                                name="delete_deck">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                        <div class="card-front">
                                            <p class="mb-3"><?= htmlspecialchars($card['front_text']) ?></p>
                                            <button class="show-answer btn btn-sm btn-outline-primary">
                                                Show Answer
                                            </button>
                                        </div>
                                        <div class="card-back d-none">
                                            <hr>
                                            <p class="mb-0"><?= htmlspecialchars($card['back_text']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php include "delete_card.php"; include "edit_card.php"; endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php include 'edit_deck.php'; include 'delete_deck.php'; endforeach; ?>
    </div>
</div>


<div class="modal fade" id="addCard" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="add_card.php">
                <input type="hidden" name="deck_id" id="deckId">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fs-5">Add New Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="frontText" class="form-label">Question</label>
                        <input type="text" class="form-control mb-3 card-question-input" id="frontText"
                               placeholder="Enter your question" name="front_text" required>
                    </div>
                    <div class="mb-3">
                        <label for="backText" class="form-label">Answer</label>
                        <input type="text" class="form-control card-answer-input" id="backText"
                               placeholder="Enter the answer" name="back_text" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add-card" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Card
                    </button>
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

    // document.querySelectorAll(".toggle-display").forEach(btn => {
    //     btn.addEventListener("click", () => {
    //         document.querySelector(".card-display").classList.toggle("d-none");
    //     });
    // });

    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("toggle-card-display")) {
            const toggleDisplay = event.target;
            const cardDisplay = toggleDisplay.closest(".deck").querySelector(".card-display");

            cardDisplay.classList.toggle("d-none");
            toggleDisplay.textContent = cardDisplay.classList.contains("d-none")
            ? "Show Cards" : "Hide Cards";
        }
    })

    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("show-answer")) {
            const toggleButton = event.target;
            const card = toggleButton.closest(".card");
            const back = card.querySelector(".card-back");

            back.classList.toggle("d-none");
            toggleButton.textContent = back.classList.contains("d-none")
            ? "Show Answer" : "Hide Answer";
        }
    });


</script>

<script src="createDeck.js"></script>
</body>

</html>
