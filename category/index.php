<?php
require_once '../db.php';
$categories = categoriesWithSub($conn);

if (!isset($_GET['id'])) {
	header('Location: ../');
	die('Missing id.');
}

$sql = "SELECT Name FROM TbCategories WHERE Id = :category";
$stmt = $conn->prepare($sql);
$stmt->execute([
	':category' => $_GET['id']
]);
$categoryName = $stmt->fetch();
if (!$categoryName) {
	header('Location: ../');
	die('Wrong category.');
}
$categoryName = $categoryName[0];

if (!isset($_GET['page']) || !ctype_digit($_GET['page'])) {
	$page = 1;
} else {
	$_GET['page'] < 1 ? $page = 1 : $page = (int) $_GET['page'];
}

$page == 1 ? $pageSql = 0 : $pageSql = ($page - 1) * 5 - 1;


$sql = "SELECT count(*) FROM (SELECT TbArticles.Id
FROM TbArticles INNER JOIN TbArticleCategories ON TbArticles.Id = TbArticleCategories.IdArticle
WHERE TbArticles.Published = 1 AND TbArticles.PublishedDate <= NOW() AND TbArticleCategories.IdCategory = :category GROUP BY TbArticles.Id) as Articles;";
$stmt = $conn->prepare($sql);
$stmt->execute([
	':category' => $_GET['id']
]);
$count = $stmt->fetch();
$pageCount = ceil(($count[0] < 1 ? 1 : $count[0]) / 5);

if ($page > $pageCount) {
	header('Location: ?id=' . $_GET['id'] . '&page=' . $pageCount);
	die('Redirect.');
}

$sql = "SELECT TbArticles.Id, TbArticles.Title, TbArticles.Summary, TbArticles.PublishedDate, TbArticles.UpdatedDate
FROM TbArticles INNER JOIN TbArticleCategories ON TbArticles.Id = TbArticleCategories.IdArticle
WHERE TbArticles.Published = 1 AND TbArticles.PublishedDate <= NOW() AND TbArticleCategories.IdCategory = :category GROUP BY TbArticles.Id ORDER BY TbArticles.PublishedDate DESC LIMIT " . $pageSql . ",5;";
$stmt = $conn->prepare($sql);
$stmt->execute([
	':category' => $_GET['id']
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
		<?= $categoryName . ' - ' ?>News
	</title>
	<?php require_once '../meta.php'; ?>
</head>

<body>
	<?php require_once '../header.php'; ?>
	<main>
		<div id="top">
			<a href="/" aria-label="Home" id="topLogo"><img src="/source/logo.svg" alt="News" height=64></a>
			<a href="/">Home</a>
			<?php foreach (categoriesWithSub($conn) as $category): ?>
			<a class="<?=(isset($_GET['id']) && $_GET['id'] == $category['Id']) ? "selected" : "" ?>"
				href="/category/?id=<?= $category['Id'] ?>">
				<?= $category['Name'] ?>
			</a>
			<?php endforeach; ?>
		</div>
		<div class="category">
			<div class="categoriesList">
				<span class="parentCategory">
					<?= strtoupper($categoryName) ?>
				</span>
			</div>
			<?php if (empty($articles)): ?>
			<div class="articlesEmpty articleRow">There is nothing published is this category.</div>
			<?php else: ?>
			<div class="articles">
				<?php foreach ($articles as $k => $a): ?>
				<div class="article articleSummary articleRow">
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
						<div class="articleInfo">
							<span>
								<?=!is_null($a['UpdatedDate']) ? 'UPDATED ' . formatTime($a['UpdatedDate']) :
							    	formatTime($a['PublishedDate']) ?>
							</span>
							<?php if (count($a['Authors']) == 1): ?>
							<span>•</span>
							<a class="author" href="/profile/?id=<?= $a['Authors'][0]['Id'] ?>">
								<?= getUserName($a['Authors'][0]) ?>
							</a>
							<?php endif; ?>
							<?php if (count($a['Authors']) > 1): ?>
							<span>+ <?=(count($a['Authors']) - 1) ?> other(s)</span>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php require_once '../pagecontrol.php' ?>
	</main>
</body>

</html>