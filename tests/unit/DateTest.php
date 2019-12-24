<?php
use \Codeception\Util\Debug;

/**
 * @group ready
 */
class DateTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [
        'testfileIterator'                             => ['dateaxisex1.php'],
        'testExampleOnDateScale'                       => ['dateaxisex2.php', 'dateaxisex3.php', 'dateaxisex4.php'],
        'testCurrentBids'                              => ['datescaleticksex01.php'],
        'testDevelopmentSince'                         => ['dateutilex01.php', 'dateutilex02.php'],
        'testAccumulatedValuesWithSpecifiedXAxisScale' => ['prepaccdata_example.php'],
    ];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];

    public static function setUpBeforeClass()
    {
        $className = str_replace('test', '', strtolower(__CLASS__));

        self::$files   = self::getFiles($className);
        $knownFixtures = self::getShallowFixtureArray(self::$fixTures);

        self::$files = array_filter(self::$files, function ($filename) use ($knownFixtures) {
            return !array_key_exists($filename, $knownFixtures);
        });

        Debug::debug(__CLASS__ . ' has ' . count(self::$files) . ' files');

    }

    protected function _before() {}

    protected function _after() {}

    public function testExampleOnDateScale()
    {
        foreach (self::$fixTures['testExampleOnDateScale'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testCurrentBids()
    {
        foreach (self::$fixTures['testCurrentBids'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testDevelopmentSince()
    {
        foreach (self::$fixTures['testDevelopmentSince'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testAccumulatedValuesWithSpecifiedXAxisScale()
    {
        foreach (self::$fixTures['testAccumulatedValuesWithSpecifiedXAxisScale'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry);
            return $carry;
        }, []);
    }
}
