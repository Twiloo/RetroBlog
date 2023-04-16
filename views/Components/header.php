<header role="header">
    <div id="header-logo"><img draggable="false" class="fill" onclick="location.href = '<?php echo HOME_URL; ?>'" src="/img/logo.png" alt="Logo <?php echo SITE_NAME; ?>"></div>
    <div id="header-title" onclick="location.href = '<?php echo HOME_URL; ?>'"><h1><?php echo SITE_NAME; ?></h1></div>
    <nav id="header-main">
        <?php
            $linkedPages = $data['linkedPages'];
            $count = count($linkedPages);
            for ($i=0; $i < $count; $i++) {
                $pageName = array_keys($linkedPages)[$i];
                $pageLink = array_values($linkedPages)[$i];
                echo "<a class=\"header-link\" href='".HOME_URL."$pageLink'>$pageName</a>";
                if ($i < $count - 1)
                    echo '<span class="header-separator"></span>';
            }
        ?>
    </nav>
    <nav id="header-menu">
        <a href="#">Compte</a>
    </nav>
</header>
