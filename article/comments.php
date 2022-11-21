<?php
require_once '../db.php';

if (!isset($_GET['id'])) {
	header('Location: ../');
	die('Missing id.');
}

$sql = "SELECT Title FROM TbArticles WHERE Published = 1 AND PublishedDate <= NOW() AND Id = :id;";
$stmt = $conn->prepare($sql);
$stmt->execute([
	':id' => $_GET['id']
]);
$articleName = $stmt->fetch()[0];

if (!$articleName) {
	header('Location: ../');
	die('Invalid article.');
}

if (!isset($_GET['page']) || !ctype_digit($_GET['page'])) {
	$page = 1;
} else {
	$_GET['page'] < 1 ? $page = 1 : $page = (int) $_GET['page'];
}

$page == 1 ? $pageSql = 0 : $pageSql = ($page - 1) * 10 - 1;

$sql = "SELECT count(*) FROM (SELECT * FROM TbComments WHERE TbComments.Id = :id AND TbComments.IdComment = NULL) as Comments";
$stmt = $conn->prepare($sql);
$stmt->execute([
	':id' => $_GET['id']
]);
$count = $stmt->fetch()[0];
$pageCount = ceil(($count < 1 ? 1 : $count) / 10);

if ($page > $pageCount) {
	header('Location: ?id=' . $_GET['id'] . '&page=' . $pageCount);
	die('Redirect.');
}

$sql = "SELECT TbComments.*, TbUsers.Id as UserId, TbUsers.Email, TbUsers.Name, TbUsers.Surname, TbUsers.Photo,
(SELECT COUNT(*) FROM TbReactions WHERE IdComment = TbComments.Id) as Reactions FROM TbComments
INNER JOIN TbUsers ON TbUsers.Id = TbComments.IdUser WHERE TbComments.IdArticle = :id AND TbComments.IdComment IS NULL ORDER BY Reactions DESC LIMIT " . $pageSql . ",10;";
$stmt = $conn->prepare($sql);
$stmt->execute([
	':id' => $_GET['id']
]);
$parentComments = $stmt->fetchAll();
foreach ($parentComments as $parentCommentkey => $parentComment) {
	$sql = "SELECT * FROM TbReactions WHERE IdComment = :commentId";
	$stmt = $conn->prepare($sql);
	$stmt->execute([
		':commentId' => $parentComment['Id']
	]);
	$comments[$parentCommentkey]['Reactions'] = $stmt->fetchAll();
	$parentComments[$parentCommentkey]['Comments'] = commentChildren($conn, $_GET['id'], $parentComment['Id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>
		<?= $articleName . ' - ' ?>News
	</title>
	<?php require_once '../meta.php'; ?>
	<link rel="stylesheet" href="comments.css">
</head>

<body>
	<?php require_once '../header.php'; ?>
	<main>
		<?php require_once '../top.php' ?>
		<h1 id="articleName">Discussion for: <?= $articleName ?></h1>
		<a id="back" href="index.php?id=<?= $_GET['id'] ?>">< Go back</a>
		<?php if (!empty($_SESSION['user'])) : ?>
			<form id="commentForm" action="addComment.php?id=<?= $_GET['id'] ?>" method="post">
				<div id="commentForm_profile">
					<a href='/profile/?id=<?= $_SESSION['user']['Id'] ?>'>
						<div class='photo'>
							<img src='<?= getUserPhoto($_SESSION['user']) ?>'></img>
						</div>
					</a>
					<div class='name'>
						<a href='/profile/?id=<?= $_SESSION['user']['Id'] ?>'><?= getUserName($_SESSION['user']) ?></a>
					</div>
				</div>
				<div id="reply_element" class="hidden"><span id="reply_text"></span><span onclick="removeReply()">⛌</span></div>
				<input id="commentForm_reply" name="reply" value type="hidden">
				<textarea id="commentForm_content" name="content" placeholder="Add your comment..."></textarea>
				<div id="commentForm_submit">
					<input type="submit" value="Send">
				</div>
			</form>
		<?php else : ?>
			<p id="notLogged">To contribute to the discussion, you need to&nbsp;<a href='/login/?r=<?= $_SERVER['REQUEST_URI'] ?>'>log in</a>.</p>
		<?php endif; ?>
		<div id='comments'>
			<?php foreach ($parentComments as $comment) : ?>
				<?= commentHtml($conn, $comment) ?>
			<?php endforeach; ?>
		</div>
		<?php require_once '../pagecontrol.php' ?>
	</main>
</body>

<script>
	var reply_element = document.getElementById('reply_element');
	var reply_text = document.getElementById('reply_text');
	var reply_input = document.getElementById('commentForm_reply');

	function commentReply(replyComment) {
		if (reply_element.classList.contains('hidden')) {
			reply_element.classList.remove('hidden');
		}
		reply_text.innerHTML = 'Replying to: ' + replyComment[1];
		reply_input.value = replyComment[0];
	}

	function removeReply() {
		if (!reply_element.classList.contains('hidden')) {
			reply_element.classList.add('hidden');
		}
		reply_text.innerHTML = '';
		reply_input.value = '';
	}
</script>

</html>