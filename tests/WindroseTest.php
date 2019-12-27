<?php

/**
 * @group ready
 */
class WindroseTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [
    ];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];
    public static $debugFileGroups;

    protected function _before()
    {self::$debugFileGroups = true;}

    protected function _after() {}

    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry/*, true*/);
            return $carry;
        }, self::$genericFixtures);
    }

    public function testTwoWindrosePlotsInOneGraph()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testExampleWithBackgroundFlag()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testABasicWindroseGraph()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testWindroseExample1b()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testJapaneseLocale()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testMultiplePlotsInTheSameGraph()
    {$this->traverseFixtureGroup($this->fixTures(__METHOD__));}

    public function testFreeTypePlot()
    {$this->traverseFixtureGroup($this->fixTures(__METHOD__));}

    public function testWindroseexample()
    {$this->traverseFixtureGroup($this->fixTures(__METHOD__));}

    public function testAddingLabelBackgrounds()
    {$this->traverseFixtureGroup($this->fixTures(__METHOD__));}
}
