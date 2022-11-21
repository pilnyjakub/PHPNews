<div id="pageControl">
    <a class="pageButton <?= $page == 1 ? "disabled" : "" ?>" href="<?= $page == 1 ? "" : "?id=" . $_GET['id'] ?>">&lt;&lt;</a>
    <a class="pageButton <?= $page == 1 ? "disabled" : "" ?>" href="<?= $page == 1 ? "" : "?id=" . $_GET['id'] . "&page=" . $page - ($page != $pageCount ? 1 : 2) ?>">
        <?= $page == 1 ? $page : $page - ($page != $pageCount ? 1 : 2) ?>
    </a>
    <?php if ($pageCount > 1) : ?>
        <a class="pageButton <?= (($page == $pageCount && $pageCount == 2) || ($pageCount > 2 && $page != 1 && $page != $pageCount)) ? "disabled" : "" ?>" href="<?= $page == 1 ? "?id=" . $_GET['id'] . "&page=" . $page + 1 : (($page == $pageCount && $pageCount != 2) ? "?id=" . $_GET['id'] . "&page=" . $page - 1 : "") ?>">
            <?= $page == 1 ? $page + 1 : ($page == $pageCount && $pageCount != 2 ? $page - 1 : $page) ?>
        </a>
    <?php endif; ?>
    <?php if ($pageCount > 2) : ?>
        <a class="pageButton <?= $page == $pageCount ? "disabled" : "" ?>" href="<?= $page == $pageCount ? "" : "?id=" . $_GET['id'] . "&page=" . $page + ($page != 1 ? 1 : 2) ?>">
            <?= $page == $pageCount ? $page : $page + ($page != 1 ? 1 : 2) ?>
        </a>
    <?php endif; ?>
    <a class="pageButton <?= $page == $pageCount ? "disabled" : "" ?>" href="<?= $page == $pageCount ? "" : "?id=" . $_GET['id'] . "&page=" . $pageCount ?>">&gt;&gt;</a>
</div>