<?php
require_once 'db.php';

if (empty($_GET['s'])) {
    header('Location: index.php');
    die('Invalid query.');
}

if (!isset($_GET['page']) || !ctype_digit($_GET['page'])) {
    $page = 1;
} else {
    $_GET['page'] < 1 ? $page = 1 : $page = (int) $_GET['page'];
}

$page == 1 ? $pageSql = 0 : $pageSql = ($page - 1) * 5 - 1;


$sql = "SELECT count(*) FROM (SELECT TbArticles.Id FROM TbArticles
WHERE TbArticles.Published = 1 AND TbArticles.PublishedDate <= NOW() AND (TbArticles.Title LIKE :search OR TbArticles.Summary LIKE :search) GROUP BY TbArticles.Id) as Articles;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':search' => '%' . filter_var($_GET['s'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) . '%'
]);
$count = $stmt->fetch()[0];
$pageCount = ceil(($count < 1 ? 1 : $count) / 5);

if ($page > $pageCount) {
    header('Location: search.php?s=' . $_GET['s'] . '&page=' . $pageCount);
    die('Wrong page.');
}

$sql = "SELECT TbArticles.Id, TbArticles.Title, TbArticles.Summary, TbArticles.PublishedDate, TbArticles.UpdatedDate FROM TbArticles
WHERE TbArticles.Published = 1 AND TbArticles.PublishedDate <= NOW() AND (TbArticles.Title LIKE :search OR TbArticles.Summary LIKE :search) GROUP BY TbArticles.Id ORDER BY TbArticles.PublishedDate DESC LIMIT " . $pageSql . ",5;";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':search' => "%" . filter_var($_GET['s'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "%"
]);
$articles = $stmt->fetchAll();
foreach ($articles as $k => $article) {
    $sql = "SELECT IdUser as Id, Name, Surname FROM TbArticleAuthors INNER JOIN TbAuthors ON TbArticleAuthors.IdUser = TbAuthors.Id INNER JOIN TbUsers ON TbAuthors.Id = TbUsers.Id WHERE TbArticleAuthors.IdArticle = :articleId;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':articleId' => $article['Id']
    ]);
    $articles[$k]['Authors'] = $stmt->fetchAll();
    $sql = "SELECT Photo, Title FROM `TbPhotos` WHERE IdArticle = :articleId LIMIT 1;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':articleId' => $article['Id']
    ]);
    $photo = $stmt->fetch();
    if ($photo != false) {
        $articles[$k]['Photo'] = $photo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?= filter_var($_GET['s'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) . ' - ' ?>News
    </title>
    <?php require_once 'meta.php'; ?>
</head>

<body>
    <?php require_once 'header.php'; ?>
    <main>
        <?php require_once 'top.php' ?>
        <div class="category">
            <div class="categoriesList">
                <span class="parentCategory">
                    <?= strtoupper(filter_var($_GET['s'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?>
                </span>
            </div>
        </div>
        <?php if (empty($articles)): ?>
        <div class="articleSummary articleRow">There is nothing published related to this query.</div>
        <?php else: ?>
        <div class="articles">
            <?php foreach ($articles as $k => $a): ?>
            <div class="articleSummary articleRow">
                <div>
                    <a href="/article/?id=<?= $a['Id'] ?>">
                        <?= getArticlePhoto($a['Photo']) ?>
                    </a>
                </div>
                <div class="text">
                    <a href="/article/?id=<?= $a['Id'] ?>">
                        <h3>
                            <?= $a['Title'] ?>
                        </h3>
                    </a>
                    <p>
                        <?= $a['Summary'] ?>
                    </p>
                    <div>
                        <span class="time">
                            <?=!is_null($a['UpdatedDate']) ? 'UPDATED ' . formatTime($a['UpdatedDate']) :
                                formatTime($a['PublishedDate']) ?>
                        </span>
                        <?php if (count($a['Authors']) > 0): ?>
                        <span>•</span>
                        <a class="authors" href="/profile/?id=<?= $a['Authors'][0]['Id'] ?>">
                            <?= getUserName($a['Authors'][0]) ?>
                        </a>
                        <?php endif; ?>
                        <?php if (count($a['Authors']) > 1): ?>
                        <span class="time">+ <?=(count($a['Authors']) - 1) ?> other(s)</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php require_once 'pagecontrol.php' ?>
    </main>
</body>

</html>