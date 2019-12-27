<?php

/**
 * @group ready
 */
class PieTest extends \Codeception\Test\Unit
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

    public function testpie3dFileIterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testpieFileIterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testpielabelsFileIterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function test200()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExample4OfPiePlot()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testWithHidden0Labels()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry, true);
            return $carry;
        }, self::$genericFixtures);
    }
}
