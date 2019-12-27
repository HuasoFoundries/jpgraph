<?php

/**
 * @group ready
 */
class StaticbandTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];
    public static $fixTures    = [];

    protected function _before()
    {
        //self::$persistYaml = false;
    }

    protected function _after() {}

    public function testBandRdiag()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testBandDiagcross()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testBandLdiag()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testBandSolid()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testBandHvcross()
    {

        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testBandVline()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testBandHline()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testBand3dplane()
    {

        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testCashFlow()
    {

        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testFileIterator()
    {
        self::$genericFixtures =
            array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry);
            return $carry;
        }, self::$genericFixtures);
    }
}
