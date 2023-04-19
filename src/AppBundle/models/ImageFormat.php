<?php

namespace AppBundle\models;

class ImageFormat {

    private $id = null;
    private $format;

    public function __construct(string $format, int|null $id = null) {
        $this->id = $id;
        $this->format = $format;
        if ($id == null) {
            $this->save();
        }
    }

    private function save() : void {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $db->query("INSERT INTO imageformats (format) VALUES ('$this->format')");
        $this->id = $db->lastInsertId();
    }

    public static function getImageFormatById(int $id) : ImageFormat {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $result = $db->query("SELECT * FROM imageformats WHERE id = $id LIMIT 1");
        $imageformat = $result->fetch();
        $imageformat = new ImageFormat($imageformat['format'], $imageformat['id']);
        return $imageformat;
    }

    public static function getImageFormatByFormat(string $format) : ImageFormat|null {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $result = $db->query("SELECT * FROM imageformats WHERE format = '$format' LIMIT 1");
        $imageformat = $result->fetch();
        if ($imageformat == null) {
            return null;
        }
        $imageformat = new ImageFormat($imageformat['format'], $imageformat['id']);
        return $imageformat;
    }

    public static function getImageFormats() : array {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $result = $db->query('SELECT * FROM imageformats');
        $imageformats = $result->fetchAll();
        $imageformats = array_map(function($imageformat) {
            return new ImageFormat($imageformat['format'], $imageformat['id']);
        }, $imageformats);
        return $imageformats;
    }

    public function getId() : int {
        return $this->id;
    }

    public function getFormat() : string {
        return $this->format;
    }
}
