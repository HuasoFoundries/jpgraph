<?php
use \Codeception\Util\Debug;

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

    // tests
    private function _fileCheck($filename, &$ownFixtures = [], $debug = false)
    {
        $example_title = 'file_iterator';
        ob_start();
        include self::$exampleRoot . $filename;
        $img  = (ob_get_clean());
        $size = getimagesizefromstring($img);
        $this->assertEquals('image/png', $size['mime'], 'image should have mime image/png for ' . $filename);

        return $this->_normalizeTestGroup($filename, $ownFixtures, $example_title, $debug);
    }

    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry);
            return $carry;
        }, []);
    }
}
