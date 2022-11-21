<?php
require_once '../db.php';

$sql = "SELECT TbUsers.Id, TbUsers.Name, TbUsers.Surname, TbUsers.Photo, TbAuthors.Role FROM TbAuthors 
INNER JOIN TbUsers ON TbAuthors.Id = TbUsers.Id ORDER BY TbUsers.Surname;";
$stmt = $conn->prepare($sql);
$stmt->execute([]);
$authors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Authors - News</title>
    <?php require_once '../meta.php'; ?>
    <link href="authors.css" rel="stylesheet">
</head>

<body>
    <?php require_once '../header.php'; ?>
    <main>
        <?php require_once '../top.php' ?>
        <div id="authors">
            <?php foreach ($authors as $author): ?>
            <a href="/profile/?id=<?= $author['Id'] ?>">
                <div class="author">
                    <div class="photo">
                        <img src="<?= getUserPhoto($author) ?>" />
                    </div>
                    <h3 id="center">
                        <?= strtoupper($author['Name'] . ' ' . $author['Surname']) ?>
                    </h3>
                    <p>
                        <?= isset($author['Role']) ? strtoupper($author['Role']) : "" ?>
                    </p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>