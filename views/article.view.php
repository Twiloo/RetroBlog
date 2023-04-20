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
            echo '<img id="article-image" src="/img/articles/'. $data['article']->getId() .'.'. $data['article']->getImageFormat()->getLocalFormat() .'" alt="Image de l\'article '. $data['article']->getTitle() .'">';
            echo '<p>';
            out($data['article']->getContent());
            echo '</p>';
        ?>
        </section>
    </main>

    <?php renderComponent('/postLoader.html', $data); ?>
</body>
</html>