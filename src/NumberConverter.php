<?php

namespace Sportradar\NUMLCD;

class NumberConverter {

    private object $jsonParser;

    public function __construct(JSONParser $jsonParser) {
        $this->jsonParser = $jsonParser;
    }

    public function convertDigitToLCD(int $input): array {
        $result = [];
        foreach ($this->jsonParser->getFile() as $data) {
            $result = $data[$input];
        }
        return $result;
    }

    public function createLCDArray(array $inputArray): array {
        $result = [];
        foreach ($inputArray as $inputDigit) {
            $result[] = $this->convertDigitToLCD($inputDigit);
        }
        return $result;
    }

    //reset counts the first element even if its empty...like by nr 1
    public function getPartsInLine(array $lcdArray): array {
        $result = [];
        for ($key = 0; $key <= count(reset($lcdArray)) - 1; $key++) {
            $result[] = array_column($lcdArray, $key);
        }
        return $result;
    }

    public function implodeEachLine(array $lcdArray): array {
        $result = [];
        foreach ($lcdArray as $lcdString) {
            $result[] = implode(' ', $lcdString);
        }
        return $result;
    }

}