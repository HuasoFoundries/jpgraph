<?php
namespace Tests\Unit;
use Tests\UnitTestTrait;


use \Codeception\Util\Debug;

/**
 * @group ready
 */
class ThemeTest extends \Tests\TestCase
{
    

    public static $fixTures    = [];
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

    public function testAquathemeExample()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testGreenthemeExample()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testOceanthemeExample()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testOrangethemeExample()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testPastelthemeExample()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testRosethemeExample()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testSoftythemeExample()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testThemefileiterator()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testUniversalthemeExample()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));

    }

    public function testVividthemeExample()
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
