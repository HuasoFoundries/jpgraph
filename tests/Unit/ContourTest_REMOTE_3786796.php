<?php

/**
 * JPGraph - Community Edition
 */

use Codeception\Util\Debug;

/**
 * @group ready
 *
 * @internal
 * 
 */
class ContourTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [];

    public static $files = null;

    public static $exampleRoot = null;

    public static $ranTests = [];

    public static function setUpBeforeClass(): void
    {
        $className = \str_replace('test', '', \mb_strtolower(__CLASS__));

        self::$files = self::getFiles($className);
        $knownFixtures = self::getShallowFixtureArray(self::$fixTures);

        self::$files = \array_filter(self::$files, function ($filename) use ($knownFixtures) {
            return !\array_key_exists($filename, $knownFixtures);
        });

        Debug::debug(__CLASS__ . ' has ' . \count(self::$files) . ' files');
    }

    public function testFileIterator()
    {
        self::$genericFixtures = \array_reduce(self::$files, function ($carry, $file) {
            return $this->_fileCheck($file, $carry);
        }, self::$genericFixtures);
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }
}
