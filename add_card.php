<?php
//
//require_once __DIR__.'/boot.php';
//require_once __DIR__.'/create_deck.php';
//
//if (isset($_POST['add-card'])) {
//    $deckId = $_POST['deck_id'];
//    $cardQuestion = $_POST['front_text'] ?? '';
//    $cardAnswer = $_POST['back_text'] ?? '';
//    $sql = ("INSERT INTO `cards` (`deck_id`, `front_text`, `back_text`) VALUES (?, ?, ?)");
//    $stmt = $pdo->prepare($sql);
//    $stmt->execute([$deckId, $cardQuestion, $cardAnswer]);
//}
//
//?>

<?php
require_once __DIR__.'/boot.php';

if (isset($_POST['add-card'])) {

        $pdo = new PDO('mysql:dbname=flashcard_app;host=127.0.0.1', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $deckId = $_POST['deck_id'];
        $cardQuestion = $_POST['front_text'] ?? '';
        $cardAnswer = $_POST['back_text'] ?? '';

        $sql = "INSERT INTO `cards` (`deck_id`, `front_text`, `back_text`) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$deckId, $cardQuestion, $cardAnswer]);

        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
}

header("Location: create_deck.php");
exit();
