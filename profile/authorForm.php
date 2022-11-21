<?php
require_once '../db.php';
if (!isSignedIn()) {
    header('Location: ../login/index.php?r=' . $_SERVER['REQUEST_URI']);
    die('Not signed in.');
}
$sql = "SELECT About, Role FROM TbAuthors WHERE Id = :userId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':userId' => $_SESSION['user']['Id']
]);
$author = $stmt->fetch();

if ($author == false) {
    header('Location: settings.php');
    die('Not author.');
}
if (isset($_POST['role'], $_POST['about'])) {
    $sql = 'UPDATE TbAuthors SET About = :about, Role = :role WHERE Id = :author';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':about' => filter_var($_POST['about'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ':role' => filter_var($_POST['role'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ':author' => $_SESSION['user']['Id']
    ]);
    $sql = 'DELETE FROM TbAuthorSocials WHERE IdAuthor = :author';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':author' => $_SESSION['user']['Id']
    ]);
    if (isset($_POST['socialsName'], $_POST['socialsURL'])) {
        foreach ($_POST['socialsName'] as $key => $socialName) {
            $socialURL = $_POST['socialsURL'][$key];
            if (!empty($socialName) && !empty($socialURL)) {
                $sql = 'INSERT INTO TbAuthorSocials SET IdAuthor = :author, Social = :social, URL = :url';
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':author' => $_SESSION['user']['Id'],
                    ':social' => filter_var($socialName, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    ':url' => filter_var($socialURL, FILTER_SANITIZE_URL)
                ]);
            }
        }
    }
}
header('Location: settings.php');
die('Redirect.');