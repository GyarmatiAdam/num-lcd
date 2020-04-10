<?php

namespace Sportradar\NUMLCD;

class Output {

    public function getNumberConverter($file):object {
        $jsonParser = new JSONParser($file);
        return $numberConverter = new NumberConverter($jsonParser);
    }

    public function getInputParser():object {
        return new InputParser();
    }

    public function getLCDNumber(string $input, $file): array {
        $numberConverter = $this->getNumberConverter($file);
        $inputParser = $this->getInputParser();
        $inputArray = $inputParser->getInput($input);
        $lcdArray = $numberConverter->createLCDArray($inputArray);
        $lcdNumbers = $numberConverter->getPartsInLine($lcdArray);
        return $numberConverter->implodeEachLine($lcdNumbers);
    }

    public function outputLCD(string $input, $file): void {
        foreach ($this->getLCDNumber($input, $file) as $string){
            echo $string . "\n";
        }
    }
}