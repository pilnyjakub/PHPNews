<?php
require_once '../db.php';
if (isset($_SESSION['user'])) {
    header('Location: ../profile/?id=' . $_SESSION['user']['Id']);
    die('Already logged in.');
}

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header('Location: ?e=notEmail' . (isset($_GET['r']) ? '&r=' . $_GET['r'] : ''));
        die('Incorrect email address format.');
    }
    $sql = 'SELECT * FROM TbUsers where Email = :email';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':email' => $_POST['email']
    ]);
    $user = $stmt->fetch();
    if ($user === false) {
        header('Location: ?e=notValid' . (isset($_GET['r']) ? '&r=' . $_GET['r'] : ''));
        die('Incorrect email address or password.');
    }
    $passwordCorrect = password_verify($_POST['password'], $user['Password']);
    if (!$passwordCorrect) {
        header('Location: ?e=notValid' . (isset($_GET['r']) ? '&r=' . $_GET['r'] : ''));
        die('Incorrect email address or password.');
    }
    $_SESSION['user'] = $user;
    header('Location: ..' . (isset($_GET['r']) ? $_GET['r'] : '/'));
    die('Logged in.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign in</title>
    <?php require_once '../meta.php'; ?>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <main>
        <a href="/"><img id="logo" src="/source/logo.svg" height=30 width=100></a>
        <h1>Sign in</h1>
        <p class="muted">Sign in to comment and more</p>
        <a href="/" id="back">
            < Go back</a>
                <form action="<?= isset($_GET['r']) ? '?r=' . $_GET['r'] : '' ?>" method="post">
                    <div>
                        <input id="email" name="email" placeholder="Email address" autocomplete="email" autofocus
                            required>
                        <?php if (isset($_GET['e']) && $_GET['e'] === 'notEmail'): ?>
                        <div class="error">Incorrect email address format.</div>
                        <?php elseif (isset($_GET['e']) && $_GET['e'] === 'notValid'): ?>
                        <div class="error">Incorrect email address or password.</div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input id="password" name="password" placeholder="Password" type="password"
                            autocomplete="current-password" required>
                        <?php if (isset($_GET['e']) && $_GET['e'] === 'notValid'): ?>
                        <div class="error">Incorrect email address or password.</div>
                        <?php endif; ?>
                    </div>
                    <input type="submit" name="submit" value="Sign in">
                    <p class="center">If you don't have an account yet, you can <a href="register.php">sign up here</a>.
                    </p>
                </form>
    </main>
</body>

</html>