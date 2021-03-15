<?php foreach ($newsList as $post) :?>
<div>
    <h3><a href="index.php?controller=News&action=view&newsId=<?= $post['news_id'] ?>"><?= htmlspecialchars($post['news_title']) ?></a></h3>
    <p>Posted by:<?= htmlspecialchars($post['user_first'] . ' ' . $post['user_last']) ?>, day: <?= $post['news_date'] ?>
        <br>
        Category: <?= htmlspecialchars($post['category_name']) ?>
    </p>
    <hr>
    <article>
        <?= \app\view\View::excerpt($post['news_article']) ?>
    </article>
    <hr>
</div>
<?php endforeach; ?>

