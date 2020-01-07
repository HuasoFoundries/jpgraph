<?php
use \Codeception\Util\Debug;

/**
 * @group ready
 */
class BackgroundTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [
        'testUsingBackgroundImage' => [

            'background_type_ex0.php',
            'background_type_ex1.php',
            'background_type_ex2.php',
            'background_type_ex3.php',
            'background_type_ex4.php',

        ],
        'testBackgroundImage'      => [
            'backgroundex01.php',
            'backgroundex02.php',
            'backgroundex03.php',
        ],

    ];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];

    public static function setUpBeforeClass(): void
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

    public function testUsingBackgroundImage()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testBackgroundImage()
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
