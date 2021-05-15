<?php

namespace Tests\Unit;

use Codeception\Util\Debug;

/**
 * @group ready
 */
class LedTest extends \Tests\TestCase
{
    public static $persistYaml = false;
    public static $fixTures    = [];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];

    public static function setUpBeforeClass(): void
    {
        $className = str_replace('test', '', strtolower(__CLASS__));

        self::$files   = self::getFiles($className);
        $knownFixtures = self::getShallowFixtureArray(self::$fixTures);
        Debug::debug($knownFixtures);
        self::$files = array_filter(self::$files, function ($filename) use ($knownFixtures) {
            return !array_key_exists($filename, $knownFixtures);
        });

        // Debug::debug(__CLASS__ . ' has ' . count(self::$files) . ' files');

    }
    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry);
            return $carry;
        }, self::$genericFixtures);
    }
}
