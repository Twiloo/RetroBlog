<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/error.css">
    <link rel="icon" href="/favicon.ico">
    <title>Erreur <?php echo $e->getCode() ?></title>
</head>
<body>
    <h1>Erreur <?php echo $e->getCode(); ?></h1>
    <p><?php echo $e->getMessage(); ?></p>
    <a href="<?php echo HOME_URL; ?>">Retour au site</a>
</body>
</html>