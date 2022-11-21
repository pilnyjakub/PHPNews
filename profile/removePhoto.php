<?php
require_once '../db.php';
if (!isSignedIn()) {
    header('Location: ../login/index.php?r=' . $_SERVER['REQUEST_URI']);
    die('Not signed in.');
}

$sql = 'SELECT Photo FROM TbUsers WHERE Id = :user';
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':user' => $_SESSION['user']['Id']
]);
$photo = $stmt->fetch()[0];
if ($photo != false) {
    $sql = 'UPDATE TbUsers SET Photo = NULL WHERE Id = :user';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':user' => $_SESSION['user']['Id']
    ]);
    unlink('../source/profiles/' . $photo);
    unset($_SESSION['user']['Photo']);
}
header('Location: settings.php');
die('Redirect.');