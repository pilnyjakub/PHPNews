<?php
require_once '../db.php';

if (!isset($_GET['id'])) {
	header('Location: ../');
	die('Missing id.');
}

$sql = "SELECT Id, Email, Name, Surname, Photo FROM TbUsers WHERE Id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([
	':id' => $_GET['id']
]);
$profile = $stmt->fetch();

if (!$profile) {
	header('Location: ../');
	die('Invalid user.');
}

$sql = "SELECT Id FROM TbUserFollows WHERE Follower = :follower AND Followed = :followed;";
$stmt = $conn->prepare($sql);
$stmt->execute([
	':follower' => isset($_SESSION['user']) ? $_SESSION['user']['Id'] : 0,
	':followed' => $_GET['id']
]);
$followed = $stmt->fetch();

$sql = "SELECT TbUsers.* FROM TbUserFollows INNER JOIN TbUsers ON TbUsers.Id = TbUserFollows.Followed WHERE TbUserFollows.Follower = :userId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
	':userId' => $_GET['id']
]);
$following = $stmt->fetchAll();

$sql = "SELECT Id, About, Role FROM TbAuthors WHERE Id = :userId;";
$stmt = $conn->prepare($sql);
$stmt->execute([
	':userId' => $_GET['id']
]);
$author = $stmt->fetch();
if ($author != false) {
	if (!isset($_GET['page']) || !ctype_digit($_GET['page'])) {
		$page = 1;
	} else {
		$_GET['page'] < 1 ? $page = 1 : $page = (int) $_GET['page'];
	}

	$page == 1 ? $pageSql = 0 : $pageSql = ($page - 1) * 5 - 1;


	$sql = "SELECT count(*) FROM (SELECT TbArticles.Id
	FROM TbArticles INNER JOIN TbArticleAuthors ON TbArticles.Id = TbArticleAuthors.IdArticle
	WHERE TbArticles.Published = 1 AND TbArticles.PublishedDate <= NOW() AND TbArticleAuthors.IdUser = :authorId) as Articles;";
	$stmt = $conn->prepare($sql);
	$stmt->execute([
		':authorId' => $author['Id']
	]);
	$count = $stmt->fetch();
	$pageCount = ceil(($count[0] < 1 ? 1 : $count[0]) / 5);

	if ($page > $pageCount) {
		header('Location: ?id=' . $_GET['id'] . '&page=' . $pageCount);
		die('Wrong page.');
	}

	$sql = "SELECT TbArticles.Id, TbArticles.Title, TbArticles.Summary, TbArticles.PublishedDate, TbArticles.UpdatedDate
	FROM TbArticles INNER JOIN TbArticleAuthors ON TbArticles.Id = TbArticleAuthors.IdArticle
	WHERE TbArticles.Published = 1 AND TbArticles.PublishedDate <= NOW() AND TbArticleAuthors.IdUser = :authorId ORDER BY TbArticles.PublishedDate DESC LIMIT " . $pageSql . ",5;";
	$stmt = $conn->prepare($sql);
	$stmt->execute([
		':authorId' => $author['Id']
	]);
	$articles = $stmt->fetchAll();
	foreach ($articles as $k => $article) {
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

	$sql = "SELECT Social, URL FROM TbAuthorSocials WHERE IdAuthor = :authorId;";
	$stmt = $conn->prepare($sql);
	$stmt->execute([
		':authorId' => $author['Id']
	]);
	$author['Socials'] = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Profile - News</title>
	<?php require_once '../meta.php'; ?>
	<link href="profile.css" rel="stylesheet">
</head>
<script>
	function toggleFollowing() {
		var following = document.getElementById("followingBox");
		following.classList.toggle("hidden");
	}
</script>

<body>
	<?php require_once '../header.php'; ?>
	<main>
		<?php require_once '../top.php' ?>
		<div id="profile">
			<div class="photo">
				<img src="<?= getUserPhoto($profile) ?>">
			</div>
			<div class="name">
				<h2>
					<?= getUserName($profile) ?>
				</h2>
				<?php if (!empty($author['Role'])): ?>
				<span id="role">
					<?= $author['Role'] ?>
				</span>
				<?php endif; ?>
				<a href="follow.php?id=<?= $_GET['id'] ?>" id="follow">
					<?= $followed != false ? '★' : '☆' ?>
				</a>
			</div>
			<span class="toggleFollowing" onclick="toggleFollowing()">Following (<?= count($following) ?>)</span>
			<div id="about">
				<?=(!empty($author['About'])) ? $author['About'] : '' ?>
			</div>
			<div>
				<?php if ($author != false && $author['Socials'] != false): ?>
				<?php foreach ($author['Socials'] as $social): ?>
				<a href="<?= $social['URL'] ?>">
					<?= $social['Social'] ?>
				</a>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<?php if (isset($_SESSION['user']) && $_SESSION['user']['Id'] == $_GET['id']): ?>
			<a id="settings" href="settings.php">⚙</a>
			<?php endif; ?>
			<div id="followingBox" class="hidden" onclick="toggleFollowing()">
				<div id="followingBox_content" onclick="event.stopPropagation()">
					<span class="toggleFollowing" onclick="toggleFollowing()">⛌</span>
					<div id="followingScroll">
						<?php foreach ($following as $f): ?>
						<a href="?id=<?= $f['Id'] ?>">
							<div class="photo">
								<img src="<?= getUserPhoto($f) ?>" />
							</div>
							<span>
								<?= getUserName($f) ?>
							</span>
						</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php if (empty($articles) && $author != false): ?>
		<div class="articlesEmpty articleRow">There is nothing published by this author.</div>
		<?php elseif ($author != false): ?>
		<div class="latestArticles">
			<?php foreach ($articles as $k => $a): ?>
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
							<?=!is_null($a['UpdatedDate']) ? 'UPDATED ' . formatTime($a['UpdatedDate']) :
					formatTime($a['PublishedDate']) ?>
						</span>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<?php if ($author != false) {
			require_once '../pagecontrol.php';
		} ?>
	</main>
</body>

</html>