<?php

namespace StandardBundle\models;

include_once 'src/FrameworkBundle/Traits/databaseTrait.php';

use FrameworkBundle\Traits\databaseTrait as databaseTrait;

class ImageFormat {

    private $id = null;
    private $receivedformat;
    private $localformat;
    private static $table = 'imageformats';

    public function __construct(string $receivedformat, string $localformat , int|null $id = null) {
        $this->id = $id;
        $this->receivedformat = $receivedformat;
        $this->localformat = $localformat;
        if ($id == null)
            $this->save();
    }

    private function save() : void {
        $db = databaseTrait::getDb();
        $table = ImageFormat::$table;
        $db->query("INSERT INTO $table (receivedformat, localformat) VALUES ('$this->receivedformat', '$this->localformat')");
        $this->id = $db->lastInsertId();
    }

    public static function getLocalFormatFromReceivedFormat(string $receivedformat) : string {
        $db = databaseTrait::getDb();
        $table = ImageFormat::$table;
        $result = $db->query("SELECT localformat FROM $table WHERE receivedformat = '$receivedformat' LIMIT 1");
        $localformat = $result->fetch();
        return $localformat;
    }

    public static function getImageFormatById(int $id) : ImageFormat {
        $db = databaseTrait::getDb();
        $table = ImageFormat::$table;
        $result = $db->query("SELECT * FROM $table WHERE id = $id LIMIT 1");
        $imageformat = $result->fetch();
        $imageformat = new ImageFormat($imageformat['format'], $imageformat['id']);
        return $imageformat;
    }

    public static function getImageFormatByReceivedFormat(string $receivedformat) : ImageFormat|null {
        $db = databaseTrait::getDb();
        $table = ImageFormat::$table;
        $result = $db->query("SELECT * FROM $table WHERE receivedformat = '$receivedformat' LIMIT 1");
        $imageformat = $result->fetch();
        if ($imageformat == null) {
            return null;
        }
        $imageformat = new ImageFormat($imageformat['receivedformat'], $imageformat['localformat'] ,$imageformat['id']);
        return $imageformat;
    }

    public static function isReceivedFormatValid(string $receivedformat) : bool {
        $db = databaseTrait::getDb();
        $table = ImageFormat::$table;
        $result = $db->query("SELECT * FROM $table WHERE receivedformat = '$receivedformat' LIMIT 1");
        $imageformat = $result->fetch();
        if ($imageformat == null) {
            return false;
        }
        return true;
    }

    public static function getImageFormats() : array {
        $db = databaseTrait::getDb();
        $table = ImageFormat::$table;
        $result = $db->query("SELECT * FROM $table");
        $imageformats = $result->fetchAll();
        $imageformats = array_map(function($imageformat) {
            return new ImageFormat($imageformat['receivedformat'], $imageformat['id']);
        }, $imageformats);
        return $imageformats;
    }

    public function getId() : int {
        return $this->id;
    }

    public function getReceivedFormat() : string {
        return $this->receivedformat;
    }

    public function getLocalFormat() : string {
        return $this->localformat;
    }
}
