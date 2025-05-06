<?php

require_once __DIR__.'/boot.php';

if (isset($_POST['delete_card'])) {

        $pdo = new PDO('mysql:dbname=flashcard_app;host=127.0.0.1', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $cardId = $_POST['card_id'];

        $sql = "DELETE FROM cards WHERE card_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cardId]);

        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
}

header("Location: create_deck.php");
exit();