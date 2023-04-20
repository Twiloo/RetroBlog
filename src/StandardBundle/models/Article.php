<?php

namespace StandardBundle\models;

include_once 'src/StandardBundle/models/ImageFormat.php';
include_once 'src/FrameworkBundle/Traits/databaseTrait.php';

use StandardBundle\models\ImageFormat as ImageFormat;
use FrameworkBundle\Traits\databaseTrait as databaseTrait;

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
        $db = databaseTrait::getDb();
        $table = Article::$table;
        $idimageformat = $this->imageformat->getId();
        $db->prepare("INSERT INTO $table (title, content, imageformat) VALUES (:title, :content, :imageformat)")->execute(array('title' => $this->title, 'content' => $this->content, 'imageformat' => $idimageformat));
        $this->id = $db->lastInsertId();
    }

    public static function getArticleById($id) : Article {
        $db = databaseTrait::getDb();
        $table = Article::$table;
        $result = $db->query("SELECT * FROM $table WHERE id = $id LIMIT 1");
        $article = $result->fetch();
        $article = new Article($article['title'], $article['content'], ImageFormat::getImageFormatById($article['imageformat']), $article['id']);
        return $article;
    }

    public static function getTopArticles(int|null $number = null) : array {
        $db = databaseTrait::getDb();
        $table = Article::$table;
        $result = $db->query("SELECT * FROM $table ORDER BY likes DESC". ($number != null ? " LIMIT $number" : ""));
        $articles = $result->fetchAll();
        $articles = array_map(function($article) {
            return new Article($article['title'], $article['content'], ImageFormat::getImageFormatById($article['imageformat']), $article['id']);
        }, $articles);
        return $articles;
    }

    public static function getRecentArticles(int|null $number = null) : array {
        $db = databaseTrait::getDb();
        $table = Article::$table;
        $result = $db->query("SELECT * FROM $table ORDER BY date DESC". ($number != null ? " LIMIT $number" : ""));
        $articles = $result->fetchAll();
        $articles = array_map(function($article) {
            return new Article($article['title'], $article['content'], ImageFormat::getImageFormatById($article['imageformat']), $article['id']);
        }, $articles);
        return $articles;
    }

    public function getId() : int {
        return $this->id;
    }

    public function getTitle() : string {
        return $this->title;
    }

    public function getContent() : string {
        return $this->content;
    }

    public function getImageFormat() : ImageFormat {
        return $this->imageformat;
    }
}
