<?php

class RadarTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures    = [];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testQualityResult()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testRadarfileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testWeeklyGoals()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testAccumulatedPpm()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testLogarithmicScale()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testRadarlogfileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testRadarWithMarks()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry);
            return $carry;
        }, self::$genericFixtures);
    }
}
