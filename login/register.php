<?php
require_once '../db.php';
if (isset($_SESSION['user'])) {
    header('Location: ../profile/?id=' . $_SESSION['user']['Id']);
    die('Already logged in.');
}

if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header('Location: ?e=notEmail');
        die('Incorrect email address format.');
    }
    if (strcmp($_POST['password'], $_POST['confirmPassword'])) {
        header('Location: ?e=passwordsNotSame');
        die('Passwords are not same.');
    }
    if (grapheme_strlen($_POST['password']) < 6) {
        header('Location: ?e=passwordShort');
        die('Password must be atleast 6 character long.');
    }
    $sql = 'SELECT * FROM TbUsers where Email = :email';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':email' => $_POST['email']
    ]);
    $user = $stmt->fetch();
    if ($user) {
        header('Location: ?e=alreadyTaken');
        die('This email address is already used.');
    }
    $sql = 'INSERT INTO TbUsers SET Email = :email, Password = :password';
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':email' => $_POST['email'],
        ':password' => $passwordHash
    ]);
    $sql = 'SELECT * FROM TbUsers where Email = :email';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':email' => $_POST['email']
    ]);
    $user = $stmt->fetch();
    $_SESSION['user'] = $user;
    header('Location: ../');
    die('Registered.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign up</title>
    <?php require_once '../meta.php'; ?>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <main>
        <a href="/"><img id="logo" src="/source/logo.svg" height=30 width=100></a>
        <h1>Sign in</h1>
        <p class="muted">Sign up to comment and more</p>
        <a href="/" id="back">
            < Go back</a>
                <form action="" method="post">
                    <div>
                        <input id="email" name="email" placeholder="Email address" autocomplete="email" autofocus
                            required>
                        <?php if (isset($_GET['e']) && $_GET['e'] === 'notEmail'): ?>
                        <div class="error">Incorrect email address format.</div>
                        <?php elseif (isset($_GET['e']) && $_GET['e'] === 'alreadyTaken'): ?>
                        <div class="error">This email address is already used.</div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input id="password" name="password" placeholder="Password" type="password"
                            autocomplete="new-password" required>
                        <?php if (isset($_GET['e']) && $_GET['e'] === 'passwordsNotSame'): ?>
                        <div class="error">Passwords are not same.</div>
                        <?php elseif (isset($_GET['e']) && $_GET['e'] === 'passwordShort'): ?>
                        <div class="error">Password must be atleast 6 characters long.</div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password"
                            type="password" autocomplete="new-password" required>
                        <?php if (isset($_GET['e']) && $_GET['e'] === 'passwordsNotSame'): ?>
                        <div class="error">Passwords are not same.</div>
                        <?php elseif (isset($_GET['e']) && $_GET['e'] === 'passwordShort'): ?>
                        <div class="error">Password must be atleast 6 characters long.</div>
                        <?php endif; ?>
                    </div>
                    <input type="submit" name="submit" value="Sign up">
                    <p class="center">If you already have an account, you can simply <a href="index.php">sign in</a>.
                    </p>
                </form>
    </main>
</body>

</html>