<?php

namespace AppBundle\controllers;

class indexController {

    public static function indexAction() : void {
        $title = 'Accueil';
        $linkedPages = [
            'Articles' => '/articles',
            'Top Articles' => '/articles/top',
            'Articles Récents' => '/articles/recent'
        ];

        $data = array(
            'title' => $title,
            'linkedPages' => $linkedPages
        );

        render('/index.view.php', $data);
    }

}