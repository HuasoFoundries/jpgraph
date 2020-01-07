<?php

/**
 * @group ready
 */
class DateTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [

    ];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];
    public static $debugFileGroups;

    protected function _before()
    {
        self::$debugFileGroups = true;
    }

    protected function _after()
    {
    }

    public function testExampleOnDateScale()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testCurrentBids()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testDevelopmentSince()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testAccumulatedValuesWithSpecifiedXAxisScale()
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
