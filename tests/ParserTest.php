<?php

namespace Sportradar\NUMLCD\Tests;

use PHPUnit\Framework\TestCase;
use Sportradar\NUMLCD\exceptions\InputException;
use Sportradar\NUMLCD\InputParser;
use Sportradar\NUMLCD\JSONParser;
use Sportradar\NUMLCD\NumberConverter;
use Sportradar\NUMLCD\Output;

class ParserTest extends TestCase {

    private object $inputParser;
    private object $numberConverter;
    private object $jsonParser;
    private object $output;

    protected function setUp(): void {
        parent::setUp();
        $this->jsonParser = new JSONParser('src/config.json');
        $this->inputParser = new InputParser();
        $this->numberConverter = new NumberConverter($this->jsonParser);
        $this->output = new Output();
    }

    /** @test */
    public function should_initialize_JSON_file() {

        $jsonFile = $this->jsonParser->getFile();

        $this->assertNotEmpty($jsonFile);
    }

    /** @test */
    public function should_convert_1_to_LCD() {
        $input = "1";
        $output = ["   ", "  |", "  |"];

        $lcdNumber = $this->numberConverter->convertDigitToLCD($input);

        $this->assertSame($output, $lcdNumber);
    }

    /** @test
     * @throws InputException
     */
    public function should_throw_error_on_invalid_input() {
        $this->expectException(InputException::class);

        $input = "23fg567";

        $this->inputParser->getInput($input);
    }

    /** @test
     * @throws InputException
     */
    public function should_throw_error_if_input_is_empty() {
        $this->expectException(InputException::class);

        $input = "";

        $this->inputParser->getInput($input);
    }

    /** @test
     * @throws InputException
     */
    public function should_convert_19_into_array() {
        $input = "19";
        $output = [1,9];

        $inputArray = $this->inputParser->getInput($input);

        $this->assertSame($output, $inputArray);
    }

    /** @test
     * @throws InputException
     */
    public function should_convert_1_and_9_to_LCD() {
        $input = "19";
        $output = [["   ", "  |", "  |"], [" _ ", "|_|", " _|"]];

        $inputArray = $this->inputParser->getInput($input);
        $lcdArray = $this->numberConverter->createLCDArray($inputArray);

        $this->assertSame($output, $lcdArray);
    }

    /** @test
     * @throws InputException
     */
    public function should_return_LCD_nums_next_to_each_other() {
        $input = "19";
        $output = [ "     _ ",
                    "  | |_|",
                    "  |  _|"];

        $inputArray = $this->inputParser->getInput($input);
        $lcdArray = $this->numberConverter->createLCDArray($inputArray);
        $lcdNumbers = $this->numberConverter->getPartsInLine($lcdArray);
        $result = $this->numberConverter->implodeEachLine($lcdNumbers);

        $this->assertSame($output, $result);
    }

    /** @test */
    public function should_output_LCD_number_and_return_NULL() {
        $input = "0123456789";

        $output = $this->output->outputLCD($input, 'src/config.json');

        $this->assertNull($output);
    }


    /** @test */
    public function should_output_CAPITAL_LCD_number_and_return_NULL() {
        $input = "0123456789";

        $output = $this->output->outputLCD($input, 'src/capital-config.json');

        $this->assertNull($output);
    }
}
