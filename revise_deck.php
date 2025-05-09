<?php
require_once __DIR__ . '/boot.php';

include 'header.php';

$deck_id = isset($_GET['deck_id']) ? (int)$_GET['deck_id'] : null;

$pdo = new PDO('mysql:dbname=flashcard_app; host=127.0.0.1', 'root', '');

$stmt = $pdo->prepare("SELECT * FROM decks WHERE deck_id=?");
$stmt->execute([$deck_id]);
$deck = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM cards WHERE deck_id = ?");
$stmt->execute([$deck['deck_id']]);
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php foreach($cards as $card): ?>
    <div id="<?= htmlspecialchars($card['card_id']) ?>" class="card mb-4 shadow-sm">
        <div class="card-body text-center">
            <div class="card-front">
                <p class="front-text fs-4 mb-4 p-3 bg-light rounded"><?= htmlspecialchars($card['front_text']) ?></p>
                <button class="show-answer btn btn-outline-primary btn-lg">
                    <i class="fas fa-eye me-2"></i>Show Answer
                </button>
            </div>
            <div class="card-back d-none">
                <p class="back-text fs-4 mb-4 p-3 bg-light rounded"><?= htmlspecialchars($card['back_text']) ?></p>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button class="prev btn btn-secondary" onclick="prevCard()">
                    <i class="fas fa-chevron-left me-2"></i>Previous
                </button>
                <button class="next btn btn-secondary" onclick="nextCard()">
                    Next<i class="fas fa-chevron-right ms-2"></i>
                </button>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="d-flex justify-content-center gap-3 mt-4">
    <a href="create_deck.php" class="exit btn btn-danger btn-lg d-none">
        <i class="fas fa-sign-out-alt me-2"></i>Finish
    </a>
    <a href="revise_deck.php?deck_id=<?=$deck['deck_id']?>" class="restart btn btn-success btn-lg d-none">
        <i class="fas fa-redo me-2"></i>Restart
    </a>
</div>

<script id="cards-data" type="application/json">
  <?= json_encode($cards, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) ?>
</script>
<script src="slider.js"></script>
<script src="deck_actions.js"></script>
