<!DOCTYPE <?php echo DOCTYPE ?>>
<html lang="<?php echo LANG ?>">
<?php renderComponent('/head.php', $data['title']); ?>
<body>
    <?php renderComponent('/preLoader.html', $data); ?>
    <?php renderComponent('/header.php', $data); ?>
    <main>
        <section>
            <h1><?php echo $data['title']; ?></h1>

            <article>
                <p>Vous souhaitez poster un article ? Remplissez le formulaire ci-dessous :</p>
                <hr>
                <form action="<?php echo HOME_URL?>/article/post" method="post" enctype="multipart/form-data">
                <span>
                    <label for="article-title">Titre de l'article</label>
                    <input type="text" name="article-title" id="article-title" required>
                </span>
                <span>
                    <label for="article-content">Article</label>
                    <textarea name="article-content" id="article-content" cols="60" rows="10" required></textarea>
                </span>
                <span>
                    <label for="article-image">Image</label>
                    <input type="file" name="article-image" id="article-image" accept=".jpg,.jpeg,.png" required>
                </span>
                <span>
                    <label></label>
                    <p>Veillez à avoir un format png/jpg pour la photo ainsi qu'une taille inférieure à 2 Mo.</p>
                </span>
                <hr>
                <span>
                    <label for="article-submit"></label>
                    <input type="submit" value="Poster" name="article-submit" id="article-submit">
                </span>
                </form>
            </article>
        </section>

        <section>
            <h2>Comment réaliser un article</h2>
            <article>
                <p>Vous pouvez réaliser un article en remplissant le formulaire ci-dessus :</p>
                <ul>
                    <li>Le titre de l'article doit être court et concis.</li>
                    <li>Le contenu de l'article doit être clair et précis.</li>
                    <li>L'image est nécessaire à la création de l'article.</li>
                </ul>
                <p>Une fois l'article posté, il sera directement publié sur le site.</p>
                <p>Si vous avez des questions, n'hésitez pas à nous contacter via la page <a href="<?php echo HOME_URL; ?>/contact">Contact</a>.</p>
            </article>
        </section>
    </main>

    <?php renderComponent('/postLoader.html', $data); ?>
</body>
</html>