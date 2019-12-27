<?php
use \Codeception\Util\Debug;

defined('TEST_INMEDIATE') || define('TEST_INMEDIATE', true);
/**
 * @group ready
 */
class CanvasTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [

        'testBezierLineWithControlPoints' => [
            'canvasbezierex1.php', // Bezier line with control points
        ],

        'testfileIterator'                => [
            'canvasex05.php', // file_iterator
            'canvasex06.php', // file_iterator
        ],

        'testCanvasSpiral'                => [
            'canvaspiralex1.php', // Canvas Spiral
        ],

        'testGenerateGradientBackground'  => [
            'example_canvas_mkgrad.php', // Generate gradient background
        ],

        'testFontDemonstrationOnCanvas'   => [
            'listfontsex1.php', // Font demonstration on canvas
        ],

        'testtextWithSeveralLines'        => [
            'text_several_lines.php', // text with several lines
        ],

        'testThisIsATextWithMoreText'     => [
            'text_with_more_text.php', // This is a text with more text
        ],

    ];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];

    public static function setUpBeforeClass(): void
    {
        $className = str_replace('test', '', strtolower(__CLASS__));

        self::$files   = self::getFiles($className);
        $knownFixtures = self::getShallowFixtureArray(self::$fixTures);

        self::$files = array_filter(self::$files, function ($filename) use ($knownFixtures) {
            return !array_key_exists($filename, $knownFixtures);
        });

        Debug::debug(__CLASS__ . ' has ' . count(self::$files) . ' files');
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry);
            return $carry;
        }, []);
    }

    public function testBezierLineWithControlPoints()
    {
        foreach (self::$fixTures['testBezierLineWithControlPoints'] as $file) {
            $this->_fileCheck($file);
        }
    }

    public function testCanvasSpiral()
    {
        foreach (self::$fixTures['testCanvasSpiral'] as $file) {
            $this->_fileCheck($file);
        }
    }

    public function testGenerateGradientBackground()
    {
        foreach (self::$fixTures['testGenerateGradientBackground'] as $file) {
            $this->_fileCheck($file);
        }
    }

    public function testFontDemonstrationOnCanvas()
    {
        foreach (self::$fixTures['testFontDemonstrationOnCanvas'] as $file) {
            $this->_fileCheck($file);
        }
    }

    public function testtextWithSeveralLines()
    {
        foreach (self::$fixTures['testtextWithSeveralLines'] as $file) {
            $this->_fileCheck($file);
        }
    }

    public function testThisIsATextWithMoreText()
    {
        foreach (self::$fixTures['testThisIsATextWithMoreText'] as $file) {
            $this->_fileCheck($file);
        }
    }
}
