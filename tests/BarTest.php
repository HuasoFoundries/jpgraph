<?php

/**
 * JPGraph - Community Edition
 */

/**
 * @group ready
 *
 * @internal
 * @coversNothing
 */
class BarTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [];

    public static $files = null;

    public static $exampleRoot = null;

    public static $ranTests = [];

    public function testExampleOfBarPlotWithAbsoluteLabels()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExampleWith2ScaleBars()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testBarPattern()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGroupedAccumulatedBarPlots()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExample()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testAdjustingTheWidth()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testAccumulatedBarPlots()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGradMidver()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGradMidhor()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGradHor()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGradVer()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGradWideMidver()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGradWideMidhor()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGradCenter()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGradRaisedPanel()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testAddingalineplottoabargraph()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testBand3dplane()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testFileIterator()
    {
        self::$genericFixtures = \array_reduce(self::$files, function ($carry, $file) {
            return $this->_fileCheck($file, $carry);
        }, self::$genericFixtures);
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }
}
