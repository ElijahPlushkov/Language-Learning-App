<?php

require_once __DIR__.'/boot.php';
require_once __DIR__.'/create_deck.php';

//$newDeckName = $_POST['new_deck_name'];
$deckId = $_POST['deck_id'];

if (isset($_POST['delete_deck'])) {
    $sql = "DELETE FROM decks WHERE deck_id= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$deckId]);

//    header('Location: ' . $_SERVER['HTTP_REFERER']);
//    exit();
}

?>

<div class="modal fade" id="deleteModal<?=$deck['deck_id']?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="deck_id" value="<?=$deck['deck_id']?>">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Deck</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h5>Delete <?=$deck['deck_name']?>?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="delete_deck" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
