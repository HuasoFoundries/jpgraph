<?php

namespace Tests\Unit;

use Tests\UnitTestTrait;


/**
 * @group ready
 */
class GanttTest extends \Tests\TestCase
{


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
    protected function _fileCheck($filename, &$ownFixtures = [], $debug = false)
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


    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$files, function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry);
            return $carry;
        }, self::$genericFixtures);
    }
}
