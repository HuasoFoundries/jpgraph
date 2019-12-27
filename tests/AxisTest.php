<?php
namespace Amenadiel\JpGraph\UnitTest;

use \Codeception\Util\Debug;

/**
 * @group ready
 */
class AxisTest extends \Codeception\Test\Unit
{
    use UnitTestTrait;

    public static $fixTures = [
        'testLabelBackground'    => [
            'axislabelbkgex01.php',
            'axislabelbkgex02.php',
            'axislabelbkgex03.php',
            'axislabelbkgex04.php',
            'axislabelbkgex05.php',
            'axislabelbkgex06.php',
            'axislabelbkgex07.php',
        ],

        'testDuplicatingYAxis'   => [
            'dupyaxisex1.php',
        ],

        'testDepthCurveDive2'    => [
            'inyaxisex1.php',
            'inyaxisex2.php',
        ],

        'testUsingMultipleYAxis' => [
            'mulyaxisex1.php',
        ],
        'testFileIterator'       => [
        ],

    ];

    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];

    public static function setUpBeforeClass(): void
    {
        self::$files   = self::getFiles();
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

    public function testLabelBackground()
    {
        foreach (self::$fixTures['testLabelBackground'] as $file) {
            $this->_fileCheck($file);
        }
    }

    public function testDuplicatingYAxis()
    {
        $existe = class_exists('\PC');
        Debug::debug('Existe \PC?', $existe);
        foreach (self::$fixTures['testDuplicatingYAxis'] as $file) {
            $this->_fileCheck($file);
        }
    }

    public function testDepthCurveDive2()
    {
        foreach (self::$fixTures['testDepthCurveDive2'] as $file) {
            $this->_fileCheck($file);
        }
    }

    public function testUsingMultipleYAxis()
    {
        foreach (self::$fixTures['testUsingMultipleYAxis'] as $file) {
            $this->_fileCheck($file);
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
