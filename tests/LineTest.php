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
class LineTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [];

    public static $files = null;

    public static $exampleRoot = null;

    public static $ranTests = [];

    public function testAddingalineplottoabargraph()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testBuiltinplotmarksfileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testCashFlow()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testCenterTheLinePointsInBars()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testCombinedBarAndLinePlot()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testEducationGrowth()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExampleOf10TopBottomGrace()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExampleOfFilledLineCenteredPlot()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExampleOfFilledLinePlot()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExampleOfLineCenteredPlot()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExampleOnTimestampCallback()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExampleSlantedXLabels()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testFilledLineWithNullValues()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testFilledYGrid()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testFuncfileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testFunctionPlot()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testFunctionPlotWithMarker()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGradbkgfileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGradientFilledLinePlot()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testLeftAlignedBars()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testLinebarfileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testLinlogfileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testManualScale()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testNaturalCubicSplines()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testNullvaluefileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testPartiallyfilledlinefileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testStepStyledExample()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testTabtitlefileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testTheTitle()
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
