<?php
require_once '../db.php';
$latestArticles = latestArticles($conn);

if (!isset($_GET['id'])) {
    header('Location: ../');
    die('Missing id.');
}

$sql = "SELECT Id, Title, Summary, Content, PublishedDate, UpdatedDate FROM TbArticles WHERE Published = 1 AND PublishedDate <= NOW() AND Id = :id;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':id' => $_GET['id']
]);
$article = $stmt->fetch();

if (!$article) {
    header('Location: ../');
    die('Invalid article.');
}

$sql = "SELECT IdUser as Id, Name, Surname FROM TbArticleAuthors INNER JOIN TbAuthors ON TbArticleAuthors.IdUser = TbAuthors.Id INNER JOIN TbUsers ON TbAuthors.Id = TbUsers.Id WHERE TbArticleAuthors.IdArticle = :articleId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':articleId' => $article['Id']
]);
$article['Authors'] = $stmt->fetchAll();
$sql = "SELECT Photo, Title, Source FROM `TbPhotos` WHERE IdArticle = :articleId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':articleId' => $article['Id']
]);
$photos = $stmt->fetchAll();
if ($photos != false) {
    $article['Photos'] = $photos;
}

$sql = "SELECT count(Id) FROM TbComments WHERE IdArticle = :articleId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':articleId' => $article['Id']
]);
$commentCount = $stmt->fetch()[0];

$sql = "SELECT count(Id) FROM TbArticleLike WHERE IdArticle = :articleId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':articleId' => $article['Id']
]);
$likeCount = $stmt->fetch()[0];

$sql = "SELECT Id FROM TbArticleLike WHERE IdArticle = :articleId AND IdUser = :userId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':articleId' => $article['Id'],
    ':userId' => (isset($_SESSION['user']) ? $_SESSION['user']['Id'] : 0)
]);
$liked = (!$stmt->fetch()) ? 0 : 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?= $article['Title'] . ' - ' ?>News
    </title>
    <?php require_once '../meta.php'; ?>
    <link rel="stylesheet" href="article.css">
</head>

<body>
    <?php require_once '../header.php'; ?>
    <main>
        <?php require_once '../top.php' ?>
        <div id="split">
            <div id="article">
                <h1>
                    <?= $article['Title'] ?>
                </h1>
                <?php if (!empty($article['Authors'])) : ?>
                    <div class="authors">
                        <div id="authorPhotos" style="margin-right: calc(<?= 30 + (count($article['Authors']) - 1) * 20 ?>px + .5rem);">
                            <?php foreach ($article['Authors'] as $authorKey => $authorPhoto) : ?>
                                <div class="authorPhoto" style="left: <?= $authorKey * 20 ?>px; z-index: <?= count($article['Authors']) - $authorKey ?>;">
                                    <img src="<?= isset($f['Photo']) ? "/source/profiles/" . $f['Photo'] : "" ?>" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php foreach ($article['Authors'] as $authorKey => $author) : ?>
                            <a class="author" href="/profile/?id=<?= $author['Id'] ?>">
                                <?= getUserName($author) ?>
                            </a>
                            <?= (count($article['Authors']) > 1 && count($article['Authors']) - 1 > $authorKey) ? ",&nbsp;" : ""
                            ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($article['Photos'])) : ?>
                    <figure>
                        <img onclick="galeryToggle()" src="<?= !empty($article['Photos'][0]['Photo']) ? (filter_var($article['Photos'][0]['Photo'], FILTER_VALIDATE_URL) ? $article['Photos'][0]['Photo'] : '/source/articles/' . $article['Photos'][0]['Photo']) : '/source/missing.png' ?>">
                        <figcaption>
                            <?= !empty($article['Photos'][0]['Title']) ? $article['Photos'][0]['Title'] : "" ?>
                        </figcaption>
                    </figure>
                    <div id="galery" class="hidden">
                        <?php foreach ($article['Photos'] as $photoKey => $photo) : ?>
                            <div class="galery_image" data-position="<?= $photoKey ?>" style="--position: <?= $photoKey ?>;">
                                <img onclick="galeryInfoToggle()" src="<?= filter_var($photo['Photo'], FILTER_VALIDATE_URL) ? $photo['Photo'] : "/source/articles/" . $photo['Photo'] ?>" title="<?= isset($photo['Title']) ? $photo['Title'] : "" ?>">
                                <div class="galeryInfo">
                                    <div class="galeryInfo_content">
                                        <?= isset($photo['Title']) ? $photo['Title'] : "" ?>
                                        <span class="source">
                                            <?= isset($photo['Source']) ? $photo['Source'] : "" ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="galeryControls">
                            <button type="button" onclick="downSlide()">&#10094;</button>
                            <div><span id="galery_position">1</span>
                                <?= ' / ' . count($article['Photos']) ?>
                            </div>
                            <button type="button" onclick="upSlide()">&#10095;</button>
                            <button type="button" onclick="galeryToggle()">&times;</button>
                        </div>
                    </div>
                <?php endif; ?>
                <p id="time">
                    <?= !is_null($article['UpdatedDate']) ? 'UPDATED ' . formatTime($article['UpdatedDate']) :
                        formatTime($article['PublishedDate']) ?>
                </p>
                <div id="summary">
                    <?= $article['Summary'] ?>
                </div>
                <div id="content">
                    <?= $article['Content'] ?>
                </div>
                <div id="actions">
                    <span class="action"><span id="heart">
                            <?= $liked ? '♥' : '♡' ?>
                        </span><a class="action" aria-label="Like" href="like.php?id=<?= $article['Id'] ?>"> Like (<?=
                                                                                                                    $likeCount ?>)</a></span>
                    <span class="action">💬<a href="comments.php?id=<?= $article['Id'] ?>" aria-label="Discussion">
                            Discussion (<?= $commentCount ?>)</a></span>
                </div>
            </div>
            <div id="latestArticles">
                <div class="categoriesList">
                    <span class="parentCategory">LATEST ARTICLES</span>
                </div>
                <?php foreach ($latestArticles as $a) : ?>
                    <div class="article articleSummary articleRow">
                        <div>
                            <a href="/article/?id=<?= $a['Id'] ?>">
                                <?= getArticlePhoto($a['Photo']) ?>
                            </a>
                        </div>
                        <div>
                            <a href="/article/?id=<?= $a['Id'] ?>">
                                <h3>
                                    <?= $a['Title'] ?>
                                </h3>
                            </a>
                            <div class="articleInfo">
                                <span>
                                    <?= !is_null($a['UpdatedDate']) ? 'UPDATED ' . formatTime($a['UpdatedDate']) :
                                        formatTime($a['PublishedDate']) ?>
                                </span>
                                <?php if (count($a['Authors']) > 0) : ?>
                                    <span>•</span>
                                    <a class="author" href="/profile/?id=<?= $a['Authors'][0]['Id'] ?>">
                                        <?= getUserName($a['Authors'][0]) ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
<script src="galery.js"></script>

</html>