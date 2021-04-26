<?php

/**
 * JPGraph - Community Edition
 */

\defined('TEST_INMEDIATE') || \define('TEST_INMEDIATE', true);
/**
 * @group ready
 *
 * @internal
 * @coversNothing
 */
class CanvasTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [];

    public static $files = null;

    public static $exampleRoot = null;

    public static $ranTests = [];

    public function testFileIterator()
    {
        self::$genericFixtures = \array_reduce(self::$files, function ($carry, $file) {
            return $this->_fileCheck($file, $carry);
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

    protected function _before()
    {
    }

    protected function _after()
    {
    }
}
