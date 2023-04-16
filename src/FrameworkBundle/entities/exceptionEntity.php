<?php

namespace Framework\entities;

class exceptionEntity extends \Exception{
    protected string $path;

    public function __construct(string $message, int $code, string $path) {
        parent::__construct($message, $code);
        $this->path = $path;
    }

    public function getPath() : string {
        return $this->path;
    }

    public function setPath(string $path) : void {
        $this->path = $path;
    }
}