<?php
require_once 'db.php';
$categories = categoriesWithSub();

$latestArticles = latestArticles();

foreach ($categories as $key => $category) {
  $sql = "SELECT TbArticles.Id, TbArticles.Title, TbArticles.Summary, TbArticles.PublishedDate, TbArticles.UpdatedDate
  FROM TbArticles INNER JOIN TbArticleCategories ON TbArticles.Id = TbArticleCategories.IdArticle
  INNER JOIN TbCategories ON TbCategories.Id = TbArticleCategories.IdCategory
  WHERE TbArticles.Published = 1 AND TbArticles.PublishedDate <= NOW() AND TbCategories.IdCategory = :category GROUP BY TbArticles.Id ORDER BY TbArticles.PublishedDate DESC LIMIT 0,5;";
  $stmt = $conn->prepare($sql);
  $stmt->execute([
    ':category' => $category['Id']
  ]);
  $categories[$key]['Articles'] = $stmt->fetchAll();
  foreach ($categories[$key]['Articles'] as $k => $article) {
    $sql = "SELECT IdUser as Id, Name, Surname FROM TbArticleAuthors INNER JOIN TbAuthors ON TbArticleAuthors.IdUser = TbAuthors.Id INNER JOIN TbUsers ON TbAuthors.Id = TbUsers.Id WHERE TbArticleAuthors.IdArticle = :articleId;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
      ':articleId' => $article['Id']
    ]);
    $categories[$key]['Articles'][$k]['Authors'] = $stmt->fetchAll();
    $sql = "SELECT Photo, Title FROM `TbPhotos` WHERE IdArticle = :articleId LIMIT 1;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
      ':articleId' => $article['Id']
    ]);
    $photo = $stmt->fetch();
    $categories[$key]['Articles'][$k]['Photo'] = $photo != false ? $photo : null;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>News</title>
  <?php require_once 'meta.php'; ?>
</head>

<body>
  <?php require_once 'header.php'; ?>
  <main>
    <div id="top">
      <a href="/" aria-label="Home" id="topLogo"><img src="/source/logo.svg" alt="News" height=64></a>
      <a class="selected" href="/">Home</a>
      <?php foreach (categoriesWithSub() as $category) : ?>
        <a href="/category/?id=<?= $category['Id'] ?>">
          <?= $category['Name'] ?>
        </a>
      <?php endforeach; ?>
    </div>
    <div id="latestArticles">
      <div class="categoriesList">
        <span class="parentCategory">LATEST ARTICLES</span>
      </div>
      <?php foreach ($latestArticles as $a) : ?>
        <div class="article articleRow">
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
    <?php foreach ($categories as $key => $category) : ?>
      <div class="category">
        <div class="categoriesList">
          <a class="parentCategory" href="/category/?id=<?= $category['Id'] ?>">
            <?= strtoupper($category['Name']) ?>
          </a>
          <?php foreach ($category['SubCategories'] as $childCategory) : ?>
            <a href="/category/?id=<?= $childCategory['Id'] ?>">
              <?= strtoupper($childCategory['Name']) ?>
            </a>
          <?php endforeach; ?>
        </div>
        <?php if (empty($category['Articles'])) : ?>
          <div class="articlesEmpty articleRow">There is nothing published is this category.</div>
        <?php else : ?>
          <div class="articles">
            <?php foreach ($category['Articles'] as $k => $a) : ?>
              <?php if ($k == 0) : ?>
                <div class="article articleSummary">
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
                        <?= !empty($a['UpdatedDate']) ? 'UPDATED ' . formatTime($a['UpdatedDate']) :
                          formatTime($a['PublishedDate']) ?>
                      </span>
                      <?php if (count($a['Authors']) == 1) : ?>
                        <span>•</span>
                        <a class="author" href="/profile/?id=<?= $a['Authors'][0]['Id'] ?>">
                          <?= getUserName($a['Authors'][0]) ?>
                        </a>
                      <?php endif; ?>
                      <?php if (count($a['Authors']) > 1) : ?>
                        <span>+ <?= (count($a['Authors']) - 1) ?> other(s)</span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php else : ?>
                <div class="article articleCol">
                  <a href="/article/?id=<?= $a['Id'] ?>">
                    <?= getArticlePhoto($a['Photo']) ?>
                  </a>
                  <a href="/article/?id=<?= $a['Id'] ?>">
                    <h3>
                      <?= $a['Title'] ?>
                    </h3>
                  </a>
                  <div class="articleInfo">
                    <span>
                      <?= !empty($a['UpdatedDate']) ? 'UPDATED ' . formatTime($a['UpdatedDate']) :
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
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </main>
</body>

</html>