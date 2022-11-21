<?php
require_once '../db.php';
if (!isSignedIn()) {
    header('Location: ../login/index.php?r=' . $_SERVER['REQUEST_URI']);
    die('Not signed in.');
}

if (isset($_POST['email'], $_POST['name'], $_POST['surname'])) {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header('Location: settings.php?e=notEmail');
        die('Incorrect email address format.');
    }
    if (!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
        if (strcmp($_POST['password'], $_POST['confirmPassword'])) {
            header('Location: settings.php?e=passwordsNotSame');
            die('Passwords are not same.');
        }
        if (grapheme_strlen($_POST['password']) < 6) {
            header('Location: settings.php?e=passwordShort');
            die('Password must be atleast 6 character long.');
        }
        $sql = 'UPDATE TbUsers SET Email = :email, Name = :name, Surname = :surname, Password = :password WHERE Id = :user';
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':email' => $_POST['email'],
            ':name' => filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            ':surname' => filter_var($_POST['surname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            ':password' => $passwordHash,
            ':user' => $_SESSION['user']['Id']
        ]);
    } else {
        $sql = 'UPDATE TbUsers SET Email = :email, Name = :name, Surname = :surname WHERE Id = :user';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':email' => $_POST['email'],
            ':name' => filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            ':surname' => filter_var($_POST['surname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            ':user' => $_SESSION['user']['Id']
        ]);
    }
    if (isset($_FILES['photo'])) {
        if (!str_contains($_FILES['photo']['type'], "image/")) {
            header('Location: settings.php?e=photoInvalidFormat');
            die('Must be an image.');
        }
        if ($_FILES['photo']['size'] > 2000000) {
            header('Location: settings.php?e=photoLargeSize');
            die('Photo is too large.');
        }
        $sql = 'SELECT Photo FROM TbUsers WHERE Id = :user';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':user' => $_SESSION['user']['Id']
        ]);
        $photo = $stmt->fetch()[0];
        if ($photo != false) {
            unlink('../source/profiles/' . $photo);
        }
        $filename = bin2hex(random_bytes(16)) . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['photo']["tmp_name"], '../source/profiles/' . $filename);
        $sql = 'UPDATE TbUsers SET Photo = :photo WHERE Id = :user';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':photo' => $filename,
            ':user' => $_SESSION['user']['Id']
        ]);
        $sql = 'SELECT * FROM TbUsers WHERE Id = :user';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':user' => $_SESSION['user']['Id']
        ]);
        $user = $stmt->fetch();
        $_SESSION['user'] = $user;
    }
}
header('Location: settings.php');
die('Redirect.');