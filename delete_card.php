<?php

require_once __DIR__.'/boot.php';
require_once __DIR__.'/create_deck.php';

$cardId = $_POST['card_id'];

if (isset($_POST['delete_card'])) {
    $sql = "DELETE FROM cards WHERE card_id= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cardId]);

}

?>

<div class="modal fade" id="deleteCardModal<?=$card['card_id']?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="card_id" value="<?=$card['card_id']?>">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h5>Delete <?= $card['front_text']?>?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="delete_card" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
