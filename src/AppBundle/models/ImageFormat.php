<?php

namespace AppBundle\models;

include_once 'src/FrameworkBundle/Traits/databaseTrait.php';

class ImageFormat {

    private $id = null;
    private $format;
    private static $table = 'imageformats';

    public function __construct(string $format, int|null $id = null) {
        $this->id = $id;
        $this->format = $format;
        if ($id == null) {
            $this->save();
        }
    }

    private function save() : void {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $table = ImageFormat::$table;
        $db->query("INSERT INTO $table (format) VALUES ('$this->format')");
        $this->id = $db->lastInsertId();
    }

    public static function getImageFormatById(int $id) : ImageFormat {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $table = ImageFormat::$table;
        $result = $db->query("SELECT * FROM $table WHERE id = $id LIMIT 1");
        $imageformat = $result->fetch();
        $imageformat = new ImageFormat($imageformat['format'], $imageformat['id']);
        return $imageformat;
    }

    public static function getImageFormatByFormat(string $format) : ImageFormat|null {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $table = ImageFormat::$table;
        $result = $db->query("SELECT * FROM $table WHERE format = '$format' LIMIT 1");
        $imageformat = $result->fetch();
        if ($imageformat == null) {
            return null;
        }
        $imageformat = new ImageFormat($imageformat['format'], $imageformat['id']);
        return $imageformat;
    }

    public static function getImageFormats() : array {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $table = ImageFormat::$table;
        $result = $db->query('SELECT * FROM $table');
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
