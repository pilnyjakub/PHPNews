<div id="top">
    <a href="/" aria-label="Home" id="topLogo"><img src="/source/logo.svg" alt="News" height=64></a>
    <a href="/">Home</a>
    <?php foreach (categoriesWithSub() as $category): ?>
    <a href="/category/?id=<?= $category['Id'] ?>">
        <?= $category['Name'] ?>
    </a>
    <?php endforeach; ?>
</div>