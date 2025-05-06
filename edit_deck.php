<?php

require_once __DIR__.'/boot.php';
require_once __DIR__.'/create_deck.php';

if (isset($_POST['edit_deck_name'])) {
    $newDeckName = $_POST['new_deck_name'];
    $deckId = $_POST['deck_id'];
    $sql = "UPDATE decks SET deck_name= ? WHERE deck_id= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$newDeckName, $deckId]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

?>

<div class="modal fade" id="editModal<?=$deck['deck_id']?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="deck_id" value="<?=$deck['deck_id']?>">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fs-5">
                        <i class="fas fa-edit me-2"></i>Edit Deck
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editDeckName<?=$deck['deck_id']?>" class="form-label fw-semibold">Deck Name</label>
                        <input type="text" name="new_deck_name" class="form-control form-control-lg"
                               id="editDeckName<?=$deck['deck_id']?>"
                               value="<?=htmlspecialchars($deck['deck_name'])?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" name="edit_deck_name" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
