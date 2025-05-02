<?php

require_once __DIR__.'/boot.php';
require_once __DIR__.'/create_deck.php';

$deckId = $_POST['deck_id'] ?? null;

$sql = $pdo->prepare("SELECT * FROM `cards` WHERE deck_id = ?");
$sql->execute([$deckId]);
$cards = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<?php foreach ($cards as $card) : if ($card['deck_id'] === $deckId) : ?>
<div id="card-<?= htmlspecialchars($card['card_id']) ?>">
<div class="card-body">
    <div class="card-front">
        <p class="card-text"><?= htmlspecialchars($card['front_text']) ?></p>
        <button class="show-answer">Show Answer</button>
    </div>
    <div class="card-back d-none">
        <p class="card-text"><?= htmlspecialchars($card['back_text']) ?></p>
    </div>
    <div class="card-actions">
        <button class="edit-card btn btn-success">Edit</button>
        <button class="delete-card btn btn-warning">Delete</button>
    </div>
</div>
</div>

<?php else : ?>
    <div class="alert alert-info">No cards in this deck yet.</div>
<?php endif; endforeach;?>
