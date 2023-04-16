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
                    


                    break;
                case 'recent':



                    break;
                default:
                    


                    break;
            }
        ?>
        </section>
    </main>

    <?php renderComponent('/postLoader.html', $data); ?>
</body>
</html>