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
