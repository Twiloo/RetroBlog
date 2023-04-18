<?php

namespace AppBundle\controllers;

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
            'linkedPages' => array(
                'Articles' => '/articles',
                'Top Articles' => '/articles/top',
                'Articles Récents' => '/articles/recent',
                'Contact' => '/contact',
                'À propos' => '/about'
            )
        );

        render('/articleform.view.php', $data);
    }

    public static function articlePostAction() {

        if (!isset($_POST['article-title']) || !isset($_POST['article-content']) || !isset($_FILES['article-image']) || $_FILES['article-image']['error'] !== 0) {
            $_SESSION['error'] = "Le formulaire n'a pas été rempli correctement.";
            header('Location: /article/new');
        } else {
            $title = $_POST['article-title'];
            $content = $_POST['article-content'];
            $imageformat = explode('.', $_FILES['article-image']['name'])[count(explode('.', $_FILES['article-image']['name']))];
            $imageformat = \AppBundle\models\ImageFormat::getImageFormatById($imageformat);
            

            $article = new \AppBundle\models\Article($title, $content, $imageformat);

            header('Location: /articles');
        }
    }

}