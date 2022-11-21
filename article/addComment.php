<?php
require_once '../db.php';
if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    die('No comment set.');
}

if (!isset($_SESSION['user'])) {
    header('Location: ../login/?r=' . $_SERVER['REQUEST_URI']);
    die('Not signed in.');
}

$sql = "SELECT Id FROM TbArticles WHERE Id = :articleId";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':articleId' => $_GET['id']
]);
$article = $stmt->fetch();
if ($article == false) {
    header('Location: ../index.php');
    die('Wrong article set.');
}

if(!empty($_POST['content'])) {
    if(empty($_POST['reply'])) {
        $sql = "INSERT INTO TbComments SET IdUser = :userId, IdArticle = :articleId, Content = :content;";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':articleId' => $_GET['id'],
            ':userId' => $_SESSION['user']['Id'],
            ':content' => $_POST['content']
        ]);
    } else {
        $sql = "SELECT Id FROM TbComments WHERE IdArticle = :articleId AND Id = :commentId OR IdArticle = :articleId AND IdComment = :commentId";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':articleId' => $_GET['id'],
            ':commentId' => $_POST['reply']
        ]);
        if(!$stmt->fetch()) {
            header('Location: comments.php?id=' . $article[0]);
            die('Wrong reply set.');
        }
        $sql = "INSERT INTO TbComments SET IdComment = :reply, IdUser = :userId, IdArticle = :articleId, Content = :content;";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':articleId' => $_GET['id'],
            ':userId' => $_SESSION['user']['Id'],
            ':content' => $_POST['content'],
            ':reply' => $_POST['reply']
        ]);
    }
}

header('Location: comments.php?id=' . $article[0]);
die('Redirect.');
