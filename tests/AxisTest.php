<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\UnitTest;

/**
 * @group ready
 *
 * @internal
 * @coversNothing
 */
class AxisTest extends \Codeception\Test\Unit
{
    use UnitTestTrait;

    public static $fixTures = [
    ];

    public static $files = null;

    public static $exampleRoot = null;

    public static $ranTests = [];

    public function testDepthcurvedive()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testLabelBackground()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testDuplicatingYAxis()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
    }

    public function testUsingMultipleYAxis()
    {
        $this->traverseFixtureGroup($this->fixTures(__METHOD__));
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
