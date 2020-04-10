<?php

namespace Sportradar\NUMLCD;

class JSONParser {

    private string $file;

    public function __construct(string $file) {
        $this->file = $file;
    }

    private function setFile(): object {
        $jsonString = file_get_contents($this->file);
        return json_decode($jsonString);
    }

    public function getFile(): object {
        return $this->setFile();
    }
}