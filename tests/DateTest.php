<?php

/**
 * JPGraph - Community Edition
 */

/**
 * @group ready
 *
 * @internal
 * 
 */
class DateTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [
    ];

    public static $files = null;

    public static $exampleRoot = null;

    public static $ranTests = [];

    public static $debugFileGroups;

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
        self::$genericFixtures = \array_reduce(self::$files, function ($carry, $file) {
            return $this->_fileCheck($file, $carry);
        }, self::$genericFixtures);
    }

    protected function _before()
    {
        self::$debugFileGroups = true;
    }

    protected function _after()
    {
    }
}
