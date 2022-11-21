<?php
require_once 'db.php';
if (isSignedIn()) {
	$headerUsername = getUserName($_SESSION['user']);
}


$headerCategories = categoriesWithSub($conn);

$sql = 'SELECT TbUsers.Id, TbUsers.Name, TbUsers.Surname FROM `TbArticleAuthors` INNER JOIN TbUsers ON TbArticleAuthors.IdUser = TbUsers.Id INNER JOIN TbArticles ON TbArticleAuthors.IdArticle = TbArticles.Id GROUP BY TbUsers.Id ORDER BY MAX(TbArticles.PublishedDate) DESC;';
$stmt = $conn->prepare($sql);
$stmt->execute();
$headerLatestAuthors = $stmt->fetchAll();

?>

<script>
	function toggleNav(e) {
		var nav = document.getElementById("sideNav");
		nav.classList.toggle("hidden");
		var navContent = document.getElementById("sideNav_content");
		navContent.classList.toggle("hidden");
		var btn = document.getElementById("toggleNav");
		if (btn.textContent == '⛌') {
			btn.textContent = '☰'
		} else {
			btn.textContent = '⛌';
		}
	}

	function toggleProfile() {
		var profile = document.getElementById("profileDrop");
		profile.classList.toggle("hidden");
		var notifications = document.getElementById("notifications");
		if (!notifications.classList.contains('hidden')) {
			notifications.classList.add('hidden');
		}
	}

	function toggleNotifications() {
		var notifications = document.getElementById("notifications");
		notifications.classList.toggle("hidden");
		var profile = document.getElementById("profileDrop");
		if (!profile.classList.contains('hidden')) {
			profile.classList.add('hidden');
		}
	}
</script>

<header>
	<div>
		<div class="left">
			<span id="toggleNav" onclick="toggleNav()">&#9776;</span>
			<a href="/" aria-label="Home"><img id="headerLogo" src="/source/logo.svg" alt="News" height=24 width=120></a>
		</div>
		<div id="sideNav" class="hidden" onclick="toggleNav()">
			<div id="sideNav_content" class="hidden" onclick="event.stopPropagation()">
				<a id="sideNav_home" href="/">Home</a>
				<?php foreach ($headerCategories as $parentCategory) : ?>
					<a href="/category/?id=<?= $parentCategory['Id'] ?>">
						<?= $parentCategory['Name'] ?>
					</a>
					<div class="subCategories">
						<?php foreach ($parentCategory['SubCategories'] as $childCategory) : ?>
							<a href="/category/?id=<?= $childCategory['Id'] ?>">
								<?= $childCategory['Name'] ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<a href="/authors">Authors</a>
				<div class="subCategories">
					<?php foreach ($headerLatestAuthors as $latestAuthor) : ?>
						<a href="/profile/?id=<?= $latestAuthor['Id'] ?>">
							<?= $latestAuthor['Name'] . ' ' . $latestAuthor['Surname'] ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<form method="get" action="/search.php">
		<input type="search" name="s" placeholder="Search...">
		<button type="submit">&#8981;</button>
	</form>
	<div class="right">
		<?php if (isSignedIn()) : ?>
			<div id="toggleNotifications" onclick="toggleNotifications()">
				✉
			</div>
			<div id="notifications" class="hidden">
				<h3>Notifications</h3>
			</div>
			<div id="toggleProfile" onclick="toggleProfile()">
				<img src="<?= getUserPhoto($_SESSION['user']) ?>">
			</div>
			<div id="profileDrop" class="hidden">
				<span>
					<?= $headerUsername ?>
				</span>
				<a href="/profile/?id=<?= $_SESSION['user']['Id'] ?>">Edit profile</a>
				<a href="/login/logout.php?r=<?= $_SERVER['REQUEST_URI'] ?>">Logout</a>
			</div>
		<?php else : ?>
			<a id="headerLogin" href="/login/?r=<?= $_SERVER['REQUEST_URI'] ?>">Sign&nbsp;in</a>
		<?php endif; ?>
	</div>
</header>