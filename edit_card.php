<?php

require_once __DIR__.'/boot.php';
require_once __DIR__.'/create_deck.php';

$newCardFront = $_POST['newCardFront'];
$newCardBack = $_POST['newCardBack'];
$cardId = $_POST['card_id'];

if (isset($_POST['editCard'])) {
    $sql = "UPDATE cards SET front_text= ?, back_text= ? WHERE card_id= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$newCardFront, $newCardBack, $cardId]);
}

?>

<div class="modal fade" id="editCardModal<?=$card['card_id']?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="card_id" value="<?=$card['card_id']?>">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fs-5">
                        <i class="fas fa-edit me-2"></i>Edit Deck
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editCardFront<?=$card['front_text']?>" class="form-label fw-semibold">Question</label>
                        <input type="text" name="newCardFront" class="form-control form-control-lg"
                               id="editCardFront<?=$card['card_id']?>"
                               value="<?=htmlspecialchars($card['front_text'])?>">

                        <label for="editCardBack<?=$card['back_text']?>" class="form-label fw-semibold">Answer</label>
                        <input type="text" name="newCardBack" class="form-control form-control-lg"
                               id="editCardBack<?=$card['card_id']?>"
                               value="<?=htmlspecialchars($card['back_text'])?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" name="editCard" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
