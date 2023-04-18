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

    public static function getImageFormatById($id) : ImageFormat {
        $db = \FrameworkBundle\Traits\databaseTrait::getDb();
        $result = $db->query("SELECT * FROM imageformats WHERE id = $id LIMIT 1");
        $imageformat = $result->fetch();
        $imageformat = new ImageFormat($imageformat['format'], $imageformat['id']);
        return $imageformat;
    }
}
