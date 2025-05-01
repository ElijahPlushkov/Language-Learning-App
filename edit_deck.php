<?php

require_once __DIR__.'/boot.php';
require_once __DIR__.'/create_deck.php';

$newDeckName = $_POST['new_deck_name'];
$deckId = $_POST['deck_id'];

if (isset($_POST['edit_deck_name'])) {
    $sql = "UPDATE decks SET deck_name= ? WHERE deck_id= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$newDeckName, $deckId]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

?>

<div class="modal fade" id="editModal<?=$deck['deck_id']?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="deck_id" value="<?=$deck['deck_id']?>">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Deck</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Deck Name</label>
                        <input type="text" name="new_deck_name" class="form-control"
                               value="<?=htmlspecialchars($deck['deck_name'])?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="edit_deck_name" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
