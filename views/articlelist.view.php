<?php 
    require_once 'src/StandardBundle/Models/Article.php';
    use StandardBundle\models\Article as Article;
?>
<!DOCTYPE <?php echo DOCTYPE ?>>
<html lang="<?php echo LANG ?>">
<?php renderComponent('/head.php', $data['title']); ?>
<body>
    <?php renderComponent('/preLoader.html', $data); ?>
    <?php renderComponent('/header.php', $data); ?>
    <main>
        <section>
        <?php
            echo '<h1>' . $data['title'] . '</h1>';
            switch ($data['order']) {
                case 'top':
                    echo '<div class="article-list">';
                    $articles = Article::getTopArticles();
                    foreach ($articles as $article) {
                        echo '<a href="/article/'. $article->getId() .'">';
                        echo '<div class="article-list-item" style="background-image: url(/img/articles/'. $article->getId() .'.'. $article->getImageFormat()->getLocalFormat() .');">';
                        echo '<h2>';
                        out($article->getTitle());
                        echo '</h2>';
                        echo '</div>';
                        echo '</a>';
                    }
                    echo '</div>';

                    break;
                case 'recent':
                    echo '<div class="article-list">';
                    $articles = Article::getRecentArticles();
                    foreach ($articles as $article) {
                        echo '<a href="/article/'. $article->getId() .'">';
                        echo '<div class="article-list-item" style="background-image: url(/img/articles/'. $article->getId() .'.'. $article->getImageFormat()->getLocalFormat() .');">';
                        echo '<h2>';
                        out($article->getTitle());
                        echo '</h2>';
                        echo '</div>';
                        echo '</a>';
                    }
                    echo '</div>';

                     break;
                default:
                    $recentarticles = Article::getRecentArticles(6);
                    $toparticles = Article::getTopArticles(6);
                    echo '<h2>Articles récents</h2>';
                    echo '<div class="article-list">';
                    foreach ($recentarticles as $article) {
                        echo '<a href="/article/'. $article->getId() .'">';
                        echo '<div class="article-list-item" style="background-image: url(/img/articles/'. $article->getId() .'.'. $article->getImageFormat()->getLocalFormat() .');">';
                        echo '<h3>';
                        out($article->getTitle());
                        echo '</h3>';
                        echo '</div>';
                        echo '</a>';
                    }
                    echo '</div>';
                    echo '<h2>Top Articles</h2>';
                    echo '<div class="article-list">';
                    foreach ($toparticles as $article) {
                        echo '<a href="/article/'. $article->getId() .'">';
                        echo '<div class="article-list-item" style="background-image: url(/img/articles/'. $article->getId() .'.'. $article->getImageFormat()->getLocalFormat() .');">';
                        echo '<h3>';
                        out($article->getTitle());
                        echo '</h3>';
                        echo '</div>';
                        echo '</a>';
                    }
                    echo '</div>';
                    break;
            }
        ?>
        </section>
    </main>

    <?php renderComponent('/postLoader.html', $data); ?>
</body>
</html>