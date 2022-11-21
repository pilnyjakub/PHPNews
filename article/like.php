<?php
require_once '../db.php';
if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    die('No article set.');
}

if (!isset($_SESSION['user'])) {
    header('Location: ../login/index.php?r=' . $_SERVER['REQUEST_URI']);
    die('Not signed in.');
}

$sql = "SELECT Id FROM TbArticleLike WHERE IdArticle = :articleId AND IdUser = :userId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':articleId' => $_GET['id'],
    ':userId' => $_SESSION['user']['Id']
]);
$liked = (!$stmt->fetch()) ? 0 : 1;

if (!$liked) {
    $sql = 'INSERT INTO TbArticleLike SET IdArticle = :articleId, IdUser = :userId';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':articleId' => $_GET['id'],
        ':userId' => $_SESSION['user']['Id']
    ]);
    header('Location: index.php?id=' . $_GET['id'] . '#actions');
    die('Redirect.');
} else {
    $sql = 'DELETE FROM TbArticleLike WHERE IdArticle = :articleId AND IdUser = :userId';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':articleId' => $_GET['id'],
        ':userId' => $_SESSION['user']['Id']
    ]);
    header('Location: index.php?id=' . $_GET['id'] . '#actions');
    die('Redirect.');
}
