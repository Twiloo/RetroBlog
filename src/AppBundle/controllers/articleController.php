<?php

namespace AppBundle\controllers;

include_once 'src/StandardBundle/models/Article.php';

use StandardBundle\models\Article as Article;
use StandardBundle\models\ImageFormat as ImageFormat;

class articleController {

    public static function articleListAction(string $order = '') : void {
        
        $titles = array('' => 'Articles', 'top' => 'Top Articles', 'recent' => 'Articles Récents');
        $title = $titles[$order];
        
        $linkedPages = [];

        unset($titles[$order]);

        foreach ($titles as $path => $link) {
            $linkedPages[$link] = '/articles/' . $path;
        }
        
        $linkedPages['Contact'] = '/contact';
        $linkedPages['À propos'] = '/about';

        $data = array(
            'order' => $order,
            'title' => $title,
            'linkedPages' => $linkedPages
        );

        render('/articlelist.view.php', $data);
    }

    public static function articleFormAction() : void {

        $data = array(
            'title' => 'Nouvel article',
            'error' => $_SESSION['error'] ?? null,
            'linkedPages' => array(
                'Articles' => '/articles',
                'Top Articles' => '/articles/top',
                'Articles Récents' => '/articles/recent',
                'Contact' => '/contact',
                'À propos' => '/about'
            )
        );

        unset($_SESSION['error']);

        render('/articleform.view.php', $data);
    }

    public static function articlePostAction() {

        if (!isset($_POST['article-title']) || !isset($_POST['article-content']) || !isset($_FILES['article-image']) || $_FILES['article-image']['error'] !== 0) {
            $_SESSION['error'] = "Un champs du formulaire n'a pas été rempli.";
            header('Location: /article/new');
        } else {
            $title = $_POST['article-title'];
            $content = $_POST['article-content'];
            $imageformat = explode('.', $_FILES['article-image']['name'])[count(explode('.', $_FILES['article-image']['name']))-1];
            $imageformat = ImageFormat::getImageFormatByReceivedFormat($imageformat);
            
            // Vérification format d'image
            if ($imageformat == null) {
                $imageformats = ImageFormat::getImageFormats();
                $_SESSION['error'] = "Le format de l'image n'est pas valide. Les formats acceptés sont: ";
                foreach ($imageformats as $imageformat) {
                    $_SESSION['error'] .= '".'. $imageformat->getReceivedFormat() . '", ';
                }
                $_SESSION['error'] = substr($_SESSION['error'], 0, -2);
                $_SESSION['error'] .= '.';
            }

            // Vérification taille image
            if ($_FILES['article-image']['size'] > 2000000) {
                $_SESSION['error'] = "L'image est trop lourde. Elle ne doit pas dépasser 2Mo.";
            }

            // Vérification taille titre et contenu
            if (strlen($title) < 5) {
                $_SESSION['error'] = "Le titre est trop court. Ce dernier doit faire au moins 5 caractères.";
            }
            if (strlen($content) < 10) {
                $_SESSION['error'] = "Le contenu est trop court. Ce dernier doit faire au moins 10 caractères.";
            }
            if (strlen($title) > 255) {
                $_SESSION['error'] = "Le titre est trop long. Ce dernier ne doit pas dépasser 255 caractères.";
            }
            if (strlen($content) > 65535) {
                $_SESSION['error'] = "Le contenu est trop long. Ce dernier ne doit pas dépasser 65535 caractères.";
            }

            // Arrêt du script si erreur
            if (isset($_SESSION['error'])) {
                header('Location: /article/new');
                exit();
            }

            $article = new Article($title, $content, $imageformat);

            // Création de l'image redimensionnée et enregistrement dans le dossier public/img/articles
            $image = imagecreatefromstring(file_get_contents($_FILES['article-image']['tmp_name']));
            $width = imagesx($image);
            $height = imagesy($image);
            $newwidth = 450;
            $newheight = floor($height * ($newwidth / $width));
            $tmpimage = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($tmpimage, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            // Enregistrement de l'image en fonction du format de stockage local
            $imagestore = 'image'. $imageformat->getLocalFormat();
            $imagestore($tmpimage, 'public/img/articles/'. $article->getId() .'.'. $imageformat->getLocalFormat());

            header('Location: /articles');
        }
    }

}