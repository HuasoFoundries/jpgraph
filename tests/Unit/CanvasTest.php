<?php

namespace Tests\Unit;

use Tests\UnitTestTrait;


use \Codeception\Util\Debug;

defined('TEST_INMEDIATE') || define('TEST_INMEDIATE', true);
/**
 * @group ready
 */
class CanvasTest extends \Tests\TestCase
{


    public static $fixTures = [


        'testfileIterator'                => [
            'canvasex05.php', // file_iterator
            'canvasex06.php', // file_iterator
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

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry);
            return $carry;
        }, []);
    }
}
