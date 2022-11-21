<?php
require_once '../db.php';
if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    die('No comment set.');
}

if (!isset($_SESSION['user'])) {
    header('Location: ../login/index.php?r=' . $_SERVER['REQUEST_URI']);
    die('Not signed in.');
}

$sql = "SELECT IdArticle FROM TbComments WHERE Id = :commentId";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':commentId' => $_GET['id']
]);
$comment = $stmt->fetch();
if ($comment == false) {
    header('Location: ../index.php');
    die('Wrong comment set.');
}

$sql = "SELECT Id FROM TbReactions WHERE IdComment = :commentId AND IdUser = :userId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':commentId' => $_GET['id'],
    ':userId' => $_SESSION['user']['Id']
]);
$liked = (!$stmt->fetch()) ? 0 : 1;

if ($liked) {
    $sql = "DELETE FROM TbReactions WHERE IdComment = :commentId AND IdUser = :userId;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':commentId' => $_GET['id'],
        ':userId' => $_SESSION['user']['Id']
    ]);
} else {
    $sql = "INSERT INTO TbReactions SET IdComment = :commentId, IdUser = :userId, Reaction = :reaction;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':commentId' => $_GET['id'],
        ':userId' => $_SESSION['user']['Id'],
        ':reaction' => '1'
    ]);
}

header('Location: comments.php?id=' . $comment[0]);
die('Redirect.');
