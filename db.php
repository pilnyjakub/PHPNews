<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$conn = new PDO('mysql:host=localhost;dbname=DbNews', 'pilnyjakub', '123456', [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$conn->query('SET NAMES utf8');

function formatTime($timestamp)
{
	$time = strtotime($timestamp);
	$dt = new DateTime($timestamp);
	if ($time >= strtotime('today')) {
		return $dt->format('G:i');
	} else if ($time < strtotime('today') && $time >= strtotime('yesterday')) {
		return 'YESTERDAY ' . $dt->format('G:i');
	} else if ($time < strtotime('yesterday') && $time >= strtotime('first day of january this year')) {
		return $dt->format('j. n. G:i');
	} else {
		return $dt->format('j. n. Y G:i');
	}
}

function timeAgo($timestamp)
{
	$secondsDifference = time() - strtotime($timestamp);
	if ($secondsDifference < 1) {
		$secondsDifference = 1;
	}
	$conditions = array(
		12 * 30 * 24 * 60 * 60 =>  'year',
		30 * 24 * 60 * 60      =>  'month',
		24 * 60 * 60           =>  'day',
		60 * 60                =>  'hour',
		60                     =>  'minute',
		1                      =>  'second'
	);
	foreach ($conditions as $seconds => $strTime) {
		$d = round($secondsDifference / $seconds);
		if ($d >= 1) {
			$strTime .= $d > 1 ? 's' : '';
			return "$d $strTime ago";
		}
	}
}

function isSignedIn(): bool
{
	return !empty($_SESSION['user']);
}

function getUserName($user)
{
	$username = (!empty($user['Name']) && !empty($user['Surname'])) ? $user['Name'] . ' ' . $user['Surname'] : substr($user['Email'], 0, strrpos($user['Email'], '@'));
	return filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

function getUserPhoto($user)
{
	return !empty($user['Photo']) ? '/source/profiles/' . $user['Photo'] : '';
}

function getArticlePhoto($articlePhoto)
{
	$img_src = !empty($articlePhoto['Photo']) ? (filter_var($articlePhoto['Photo'], FILTER_VALIDATE_URL) ? $articlePhoto['Photo'] : '/source/articles/' . $articlePhoto['Photo']) : '/source/missing.png';
	$img_title = !empty($articlePhoto['Title']) ? $articlePhoto['Title'] : '';
	return "<img src='$img_src' title='$img_title'>";
}

function isparentCategory($category): bool
{
	return $category['Id'] == $category['IdCategory'];
}
function ischildCategory($parentCategory)
{
	return function ($category) use ($parentCategory) {
		return $category['IdCategory'] == $parentCategory && $category['Id'] != $parentCategory;
	};
}

function categoriesWithSub()
{
	global $conn;
	$sql = 'SELECT * FROM `TbCategories` ORDER BY Name';
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$categories = $stmt->fetchAll();

	foreach (array_filter($categories, "isparentCategory") as $parentCategory) {
		$parentCategory['SubCategories'] = array_filter($categories, ischildCategory($parentCategory['Id']));
		$categoriesWithSub[] = $parentCategory;
	}
	return $categoriesWithSub;
}

function latestArticles()
{
	global $conn;
	$sql = "SELECT TbArticles.Id, TbArticles.Title, TbArticles.Summary, TbArticles.PublishedDate, TbArticles.UpdatedDate FROM TbArticles
	WHERE TbArticles.Published = 1 AND TbArticles.PublishedDate <= NOW() ORDER BY TbArticles.PublishedDate DESC LIMIT 0,5;";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$latestArticles = $stmt->fetchAll();
	foreach ($latestArticles as $k => $article) {
		$sql = "SELECT IdUser as Id, Name, Surname FROM TbArticleAuthors INNER JOIN TbAuthors ON TbArticleAuthors.IdUser = TbAuthors.Id INNER JOIN TbUsers ON TbAuthors.Id = TbUsers.Id WHERE TbArticleAuthors.IdArticle = :articleId;";
		$stmt = $conn->prepare($sql);
		$stmt->execute([
			':articleId' => $article['Id']
		]);
		$latestArticles[$k]['Authors'] = $stmt->fetchAll();
		$sql = "SELECT Photo, Title FROM `TbPhotos` WHERE IdArticle = :articleId LIMIT 1;";
		$stmt = $conn->prepare($sql);
		$stmt->execute([
			':articleId' => $article['Id']
		]);
		$photo = $stmt->fetch();
		$latestArticles[$k]['Photo'] = $photo != false ? $photo : null;
	}
	return $latestArticles;
}

function commentChildren($conn, $articleId, $commentId): mixed
{
	$sql = "SELECT TbComments.*, TbUsers.Id as UserId, TbUsers.Email, TbUsers.Name, TbUsers.Surname, TbUsers.Photo,
	(SELECT COUNT(*) FROM TbReactions WHERE IdComment = TbComments.Id) as Reactions FROM TbComments
	INNER JOIN TbUsers ON TbUsers.Id = TbComments.IdUser WHERE TbComments.IdArticle = :articleId AND TbComments.IdComment = :commentId ORDER BY Reactions DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute([
		':articleId' => $articleId,
		':commentId' => $commentId
	]);
	$comments = $stmt->fetchAll();
	foreach ($comments as $key => $comment) {
		$sql = "SELECT * FROM TbReactions WHERE IdComment = :commentId";
		$stmt = $conn->prepare($sql);
		$stmt->execute([
			':commentId' => $comment['Id']
		]);
		$comments[$key]['Reactions'] = $stmt->fetchAll();
		$comments[$key]['Comments'] = commentChildren($conn, $articleId, $comment['Id']);
	}
	return $comments;
}

function reactedComment($commentId): bool
{
	global $conn;
	if (!empty($_SESSION['user'])) {
		$sql = "SELECT Reaction FROM TbReactions WHERE IdComment = :commentId AND IdUser = :userId";
		$stmt = $conn->prepare($sql);
		$stmt->execute([
			':userId' => $_SESSION['user']['Id'],
			':commentId' => $commentId
		]);
		if ($stmt->fetch() != false) {
			return true;
		}
	}
	return false;
}

function commentHtml($conn, $comment)
{
	$subComments = "";
	if (!empty($comment['Comments'])) {
		$subComments .= "<div class='subComments'>";
		foreach ($comment['Comments'] as $subComment) {
			$subComments .= commentHtml($conn, $subComment);
		}
		$subComments .= "</div>\n";
	}
	return
		"<div class='comment'>
		<div class='comment_content'>
			<a href='/profile/?id=" . $comment['UserId'] . "'>
				<div class='photo'>
					<img src='" . getUserPhoto($comment) . "'></img>
				</div>
			</a>
			<div>
				<div class='name'>
					<a href='/profile/?id=" . $comment['UserId'] . "'>" . getUserName($comment) . "</a>
					<span>•</span>
					<span class='time'>" . timeAgo($comment['PublishedDate']) . "</span>
				</div>
				<p>" . $comment['Content'] . "</p>
				<div class='actions'>
					<a class='time' href='#commentForm_content' onclick='commentReply(" . json_encode(array($comment['Id'], getUserName($comment))) . ")'>Reply</a>
					<span>•</span>
					<a href='commentLike.php?id=" . $comment['Id'] . "' aria-label='Like'><span class='heart'>" . (reactedComment($comment['Id']) ? '♥' : '♡') . "</span></a>
				</div>
			</div>
		</div>
		$subComments
	</div>\n";
}
