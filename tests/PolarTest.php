<?php

/**
 * @group ready
 */
class PolarTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures    = [];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];

    protected function _before() {}

    protected function _after() {}

    public function testClockwisePolarPlot()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testPolarplot()
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
