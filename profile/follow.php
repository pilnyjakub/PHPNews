<?php
require_once '../db.php';
if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    die('No profile set.');
}

if (!isSignedIn()) {
    header('Location: ../login/index.php?r=' . $_SERVER['REQUEST_URI']);
    die('Not signed in.');
}

$sql = "SELECT Id FROM TbUserFollows WHERE Follower = :follower AND Followed = :followed;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':follower' => $_SESSION['user']['Id'],
    ':followed' => $_GET['id']
]);
$followed = (!$stmt->fetch()) ? 0 : 1;

if (!$followed) {
    $sql = 'INSERT INTO TbUserFollows SET Follower = :follower, Followed = :followed;';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':follower' => $_SESSION['user']['Id'],
        ':followed' => $_GET['id']
    ]);
    header('Location: index.php?id=' . $_GET['id']);
    die('Redirect.');
} else {
    $sql = 'DELETE FROM TbUserFollows WHERE Follower = :follower AND Followed = :followed;';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':follower' => $_SESSION['user']['Id'],
        ':followed' => $_GET['id']
    ]);
    header('Location: index.php?id=' . $_GET['id']);
    die('Redirect.');
}