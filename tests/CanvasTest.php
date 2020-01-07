<?php

defined('TEST_INMEDIATE') || define('TEST_INMEDIATE', true);
/**
 * @group ready
 */
class CanvasTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures    = [];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];

    protected function _before() {}

    protected function _after() {}

    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry);
            return $carry;
        }, []);
    }

    public function testBezierLineWithControlPoints()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testCanvasSpiral()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testGenerateGradientBackground()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testFontDemonstrationOnCanvas()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testtextWithSeveralLines()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testThisIsATextWithMoreText()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }
}
