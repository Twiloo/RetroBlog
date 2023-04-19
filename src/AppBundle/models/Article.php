<?php

namespace AppBundle\models;

include_once 'src/AppBundle/models/ImageFormat.php';
include_once 'src/FrameworkBundle/Traits/databaseTrait.php';

class Article {

    private $id = null;
    private $title;
    private $content;
    private $imageformat;

    private static $table = 'articles';

    public function __construct(string $title, string $content, ImageFormat $imageformat, int|null $id = null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->imageformat = $imageformat;
        if ($id == null) {
            $this->save();
        }
    }

    private function save() : void {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $table = Article::$table;
        $db->query("INSERT INTO $table (title, content, imageformat) VALUES ('$this->title', '$this->content', '$this->imageformat')");
        $this->id = $db->lastInsertId();
    }

    public static function getArticleById($id) : Article {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $table = Article::$table;
        $result = $db->query("SELECT * FROM $table WHERE id = $id LIMIT 1");
        $article = $result->fetch();
        $article = new Article($article['title'], $article['content'], \AppBundle\models\ImageFormat::getImageFormatById($article['imageformat']), $article['id']);
        return $article;
    }
}
