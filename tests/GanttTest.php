<?php

/**
 * @group ready
 */
class GanttTest extends \Codeception\Test\Unit
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

    // tests
    private function _fileCheck($filename, &$ownFixtures = [], $debug = false)
    {
        if (is_array($filename)) {
            $filename = $filename['filename'];
        }
        $example_title = 'file_iterator';
        ob_start();
        include self::$exampleRoot . $filename;
        $img  = (ob_get_clean());
        $size = getimagesizefromstring($img);
        $this->assertEquals('image/png', $size['mime'], 'image should have mime image/png for ' . $filename);

        return $this->_normalizeTestGroup($filename, $ownFixtures, $example_title, $debug);
    }

    public function testExampleWithGroupingAndConstrains()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function test200()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExampleOfHoursInScale()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function test271()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testGanttChartWithTitleColumnsAndIcons()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testOnlyMonthYearScale()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testAddingASpaningTitle()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testExampleWithMultipleConstrains()
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
