<?php

require_once __DIR__.'/boot.php';
require_once __DIR__.'/create_deck.php';

$deckId = $_POST['deck_id'];
$cardQuestion = $_POST['front_text'] ?? '';
$cardAnswer = $_POST['back_text'] ?? '';

if (isset($_POST['add-card'])) {
    $sql = ("INSERT INTO `cards` (`deck_id`, `front_text`, `back_text`) VALUES (?, ?, ?)");
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$deckId, $cardQuestion, $cardAnswer]);
}

?>

<!--<div class="modal fade" id="addCard" tabindex="-1" aria-hidden="true">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="modal-content">-->
<!--            <form method="POST">-->
<!--                <input type="hidden" name="deck_id" id="deckId">-->
<!--                <div class="modal-header">-->
<!--                    <h5 class="modal-title">Add Card</h5>-->
<!--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--                </div>-->
<!--                <div class="modal-body">-->
<!--                    <div class="mb-3">-->
<!--                        <input type="text" class="card-question-input" placeholder="Question" name="front_text">-->
<!--                        <input type="text" class="card-answer-input" placeholder="Answer" name="back_text">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="modal-footer">-->
<!--                    <button type="submit" name="add-card" class="btn btn-primary">+ Add</button>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
