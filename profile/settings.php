<?php
require_once '../db.php';
if (!isSignedIn()) {
    header('Location: ../login/index.php?r=' . $_SERVER['REQUEST_URI']);
    die('Not signed in.');
}

$sql = "SELECT Email, Name, Surname, Photo FROM TbUsers WHERE Id = :userId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':userId' => $_SESSION['user']['Id']
]);
$user = $stmt->fetch();

$sql = "SELECT About, Role FROM TbAuthors WHERE Id = :userId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':userId' => $_SESSION['user']['Id']
]);
$author = $stmt->fetch();

if ($author != false) {
    $sql = "SELECT Social, URL FROM TbAuthorSocials WHERE IdAuthor = :userId;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':userId' => $_SESSION['user']['Id']
    ]);
    $authorSocials = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile - News</title>
    <?php require_once '../meta.php'; ?>
    <link href="profile.css" rel="stylesheet">
</head>

<body>
    <?php require_once '../header.php'; ?>
    <link href="settings.css" rel="stylesheet">
    <main>
        <?php require_once '../top.php' ?>
        <div id="flex">
            <form class="editProfile" action="profileForm.php" method="post" enctype="multipart/form-data">
                <h1>Edit profile</h1>
                <div>
                    <input id="email" name="email" placeholder="Email address" autocomplete="email" autofocus
                        value="<?= isset($user['Email']) ? $user['Email'] : "" ?>" required>
                    <?php if (isset($_GET['e']) && $_GET['e'] === 'notEmail'): ?>
                    <div class="error">Incorrect email address format.</div>
                    <?php elseif (isset($_GET['e']) && $_GET['e'] === 'alreadyTaken'): ?>
                    <div class="error">This email address is already used.</div>
                    <?php endif; ?>
                </div>
                <div>
                    <input id="name" name="name" placeholder="Name" type="text" autocomplete="given-name"
                        value="<?= isset($user['Name']) ? $user['Name'] : "" ?>" required>
                </div>
                <div>
                    <input id="surname" name="surname" placeholder="Surname" type="text" autocomplete="family-name"
                        value="<?= isset($user['Surname']) ? $user['Surname'] : "" ?>" required>
                </div>
                <?php if (isset($user['Photo'])): ?>
                <div id="imagePreview">
                    <img src="<?= getUserPhoto($user) ?>">
                    <a href="removePhoto.php">Remove photo</a>
                </div>
                <?php endif; ?>
                <div>
                    <p id="photoLabel">Photo</p>
                    <input id="photo" name="photo" type="file" accept="image/*">
                    <?php if (isset($_GET['e']) && $_GET['e'] === 'photoInvalidFormat'): ?>
                    <div class="error">Must be an image.</div>
                    <?php elseif (isset($_GET['e']) && $_GET['e'] === 'photoLargeSize'): ?>
                    <div class="error">Photo should not be larger than 2MB.</div>
                    <?php endif; ?>
                </div>
                <div>
                    <p>Fill in the password fields only if you want to change the password.</p>
                    <input id="password" name="password" placeholder="New password" type="password"
                        autocomplete="new-password">
                    <?php if (isset($_GET['e']) && $_GET['e'] === 'passwordsNotSame'): ?>
                    <div class="error">Passwords are not same.</div>
                    <?php elseif (isset($_GET['e']) && $_GET['e'] === 'passwordShort'): ?>
                    <div class="error">Password must be atleast 6 characters long.</div>
                    <?php endif; ?>
                </div>
                <div>
                    <input id="confirmPassword" name="confirmPassword" placeholder="Confirm new password"
                        type="password" autocomplete="new-password">
                    <?php if (isset($_GET['e']) && $_GET['e'] === 'passwordsNotSame'): ?>
                    <div class="error">Passwords are not same.</div>
                    <?php elseif (isset($_GET['e']) && $_GET['e'] === 'passwordShort'): ?>
                    <div class="error">Password must be atleast 6 characters long.</div>
                    <?php endif; ?>
                </div>
                <input type="submit" name="submit" value="Save profile">
            </form>
            <?php if ($author != false): ?>
            <form id="authorForm" class="editProfile" action="authorForm.php" method="post">
                <h1>Edit author</h1>
                <div>
                    <input id="role" name="role" placeholder="Role" type="text"
                        value="<?= isset($author['Role']) ? $author['Role'] : "" ?>" required>
                </div>
                <div>
                    <textarea id="about" name="about" placeholder="Write something about yourself..."
                        required><?= isset($author['About']) ? $author['About'] : "" ?></textarea>
                </div>
                <?php foreach ($authorSocials as $authorSocial): ?>
                <div class="social">
                    <input name="socialsName[]" placeholder="Social name" value="<?= $authorSocial['Social'] ?>">
                    <input name="socialsURL[]" placeholder="Social URL" value="<?= $authorSocial['URL'] ?>">
                    <div class="actions">
                        <button type="button" onclick="addSocial(this)">+</button>
                        <button type="button" onclick="removeSocial(this)">-</button>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="social">
                    <input name="socialsName[]" placeholder="Social name">
                    <input name="socialsURL[]" placeholder="Social URL">
                    <div class="actions">
                        <button type="button" onclick="addSocial(this)">+</button>
                        <button type="button" onclick="removeSocial(this)">-</button>
                    </div>
                </div>
                <input id="authorSubmit" type="submit" name="submit" value="Save author">
            </form>
            <?php endif; ?>
        </div>
    </main>
</body>

<script>
    var form = document.getElementById('authorForm');
    var social = document.getElementsByClassName("social");
    var social = social[social.length - 1];
    function addSocial(button) {
        var afterButton = button.parentNode.parentNode.nextElementSibling;
        var newSocial = social.cloneNode(true);
        form.insertBefore(newSocial, afterButton);
    };
    function removeSocial(button) {
        if (document.getElementsByClassName("social").length > 1) {
            button.parentNode.parentNode.remove();
        }
    };
</script>

</html>