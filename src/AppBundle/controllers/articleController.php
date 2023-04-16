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

}