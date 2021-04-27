<?php

namespace Tests\Unit;

use Tests\UnitTestTrait;



/**
 * @group ready
 *
 * @internal
 * 
 */
class BackgroundTest extends \Tests\TestCase
{


    public static $fixTures = [
        'testUsingBackgroundImage' => [
            'background_type_ex0.php',
            'background_type_ex1.php',
            'background_type_ex2.php',
            'background_type_ex3.php',
            'background_type_ex4.php',
        ],
        'testBackgroundImage' => [
            'backgroundex01.php',
            'backgroundex02.php',
            'backgroundex03.php',
        ],
    ];

    public static $files = null;

    public static $exampleRoot = null;

    public static $ranTests = [];

    public static function setUpBeforeClass(): void
    {
        $className = \str_replace('test', '', \mb_strtolower(__CLASS__));

        self::$files = self::getFiles($className);

        dump(__CLASS__ . ' has ' . count(self::$files) . ' files');
    }

    protected function _before()
    {
    }
    protected function _after()
    {
    }
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
        self::$genericFixtures = \array_reduce(self::$files, function ($carry, $file) {
            return $this->_fileCheck($file, $carry);
        }, self::$genericFixtures);
    }
}
