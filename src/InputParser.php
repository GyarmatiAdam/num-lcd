<?php

namespace Sportradar\NUMLCD;

use Sportradar\NUMLCD\exceptions\InputException;

class InputParser {

    private function setInput(string $input): array {
        $stringArray = str_split($input);
        return array_map('intval', $stringArray);
    }

    /**
     * @param string $input
     * @return array
     * @throws InputException
     */
    public function getInput(string $input): array {
        if (!is_numeric($input)) {
            throw new InputException("The input value is not numeric");
        }elseif (!isset($input)){
            throw new InputException("The input field is empty");
        } else {
            return $this->setInput($input);
        }
    }
}