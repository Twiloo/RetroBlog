<?php

include_once 'app/config.php';

try {

    $sql = "CREATE DATABASE IF NOT EXISTS ".DB_NAME." DEFAULT CHARACTER SET ". DB_CHARSET ." COLLATE ". DB_CHARSET_COLLATE .";";
    $dbexist = mysqli_query(mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD), $sql);
    
    if ($dbexist == false) {
        throw new Exception('Erreur lors de la création de la base de données');
    };

    $bdd = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);
    
    $bdd->query("CREATE TABLE IF NOT EXISTS `imageformats` (
        `id` tinyint(3) NOT NULL AUTO_INCREMENT,
        `receivedformat` varchar(255) NOT NULL,
        `localformat` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=". DB_CHARSET .";");

    $bdd->query("CREATE TABLE IF NOT EXISTS `articles` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `content` text NOT NULL,
        `imageformat` tinyint(3) NOT NULL,
        `likes` int(11) NOT NULL DEFAULT '0',
        `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=". DB_CHARSET .";");

    $bdd->query("ALTER TABLE `articles` ADD FOREIGN KEY (`imageformat`) REFERENCES `imageformats`(`id`);");

    // Verify if the table is empty

    $result = $bdd->query("SELECT * FROM `imageformats`");
    $result = $result->fetchAll();

    if (count($result) == 0) {
        $bdd->query("INSERT INTO `imageformats` (`receivedformat`, `localformat`) VALUES
        ('jpg', 'jpeg'),
        ('png', 'png'),
        ('jpeg', 'jpeg');");
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
