<!DOCTYPE <?php echo DOCTYPE ?>>
<html lang="<?php echo LANG ?>">
<?php renderComponent('/head.php', $data['title']); ?>
<body>
    <?php renderComponent('/preLoader.html', $data); ?>
    <?php renderComponent('/header.php', $data); ?>
    <main>
        <section>
            <h1>Bienvenue sur RetroBlog !</h1>
            <p>Bienvenue sur mon blog, ici vous retrouverez divers articles sur le thème des technologies les plus récentes d'internet !</p>
        </section>
        <section>
            <h2>Fonctionnement du Blog</h2>
            <p>Le blog vous est transmis via l'internet : un réseau d'ordinateurs interconnectés !</p>
        </section>
        <section>
            <h2>Particularités du Blog</h2>
            <p>Le blog a un sublime système de gestion d'erreur, disponible sur la <a href="/404">page 404</a> par exemple.</p>
        </section>
        <section>
            <h2>Me Contacter</h2>
            <p>À la vue de ce splendide site, vous souhaitez me contacter et c'est bien normal ! Sachez qu'il ne faut pas, j'écris actuellement ce texte en n'ayant réalisé les routes, le CSS, mais pas beaucoup de back... La base de donnée n'existe pas encore, mais surtout ne le dites à personnes ! (ce sera notre petit secret 👀)</p>
        </section>
    </main>
    <?php renderComponent('/postLoader.html', $data); ?>
</body>
</html>