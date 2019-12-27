<?php
use \Codeception\Util\Debug;

/**
 * @group ready
 */
class BarTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [
        'testAccumulatedBarPlots'                => [
            'accbarex1.php',
            'example23.php',
        ],
        'testfileIterator'                       => [
            'accbarframeex01.php',
            'accbarframeex02.php',
            'accbarframeex03.php',
            'barformatcallbackex1.php',
            'bargradex1.php',
            'bargradex2.php',
            'bargradex3.php',
            'bargradex4.php',
            'bargradex5.php',
            'bargradex6.php',
            'barlinealphaex1.php',
            'barlinefreqex1.php',
            'bartutex1.php',
            'bartutex12.php',
            'example18.php',
            'example19.1.php',
            'example19.php',
            'example20.1.php',
            'example20.2.php',
            'example20.3.php',
            'example20.4.php',
            'example20.5.php',
            'example20.php',
            'example25.1.php',
            'example25.2.php',
            'example25.php',
            'horizbarex4.php',
            'manual_textscale_ex2.php',
            'manual_textscale_ex3.php',
            'manual_textscale_ex4.php',
        ],
        'testExampleWith2ScaleBars'              => [
            'bar2scalesex1.php',
        ],
        'testGRADMidver'                         => [
            'bargradsmallex1.php',
        ],
        'testGRADMidhor'                         => [
            'bargradsmallex2.php',
        ],
        'testGRADHor'                            => [
            'bargradsmallex3.php',
        ],
        'testGRADVer'                            => [
            'bargradsmallex4.php',
        ],
        'testGRADWideMidver'                     => [
            'bargradsmallex5.php',
        ],
        'testGRADWideMidhor'                     => [
            'bargradsmallex6.php',
        ],
        'testGRADCenter'                         => [
            'bargradsmallex7.php',
        ],
        'testGRADRaisedPanel'                    => [
            'bargradsmallex8.php',
        ],
        'testBarPattern'                         => [
            'barpatternex1.php',
        ],
        'testAddingALinePlotToABarGraph'         => [
            'example16.2.php',
            'example16.3.php',
            'example16.4.php',
        ],
        'testExample'                            => [
            'example16.5.php',
            'example21.php',
        ],
        'testAdjustingTheWidth'                  => [
            'example22.php',
        ],
        'testGroupedAccumulatedBarPlots'         => [
            'example24.php',
        ],
        'testExampleOfBarPlotWithAbsoluteLabels' => [
            'negbarvalueex01.php',
        ],
        'testBAND3dplaneDensity'                 => [
            'plotbanddensity_ex0.php',
            'plotbanddensity_ex1.php',
            'plotbanddensity_ex2.php',
        ]];
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

    public function testAccumulatedBarPlots()
    {
        foreach (self::$fixTures['testAccumulatedBarPlots'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testExampleWith2ScaleBars()
    {
        foreach (self::$fixTures['testExampleWith2ScaleBars'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testGRADMidver()
    {
        foreach (self::$fixTures['testGRADMidver'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testGRADMidhor()
    {
        foreach (self::$fixTures['testGRADMidhor'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testGRADHor()
    {
        foreach (self::$fixTures['testGRADHor'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testGRADVer()
    {
        foreach (self::$fixTures['testGRADVer'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testGRADWideMidver()
    {
        foreach (self::$fixTures['testGRADWideMidver'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testGRADWideMidhor()
    {
        foreach (self::$fixTures['testGRADWideMidhor'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testGRADCenter()
    {
        foreach (self::$fixTures['testGRADCenter'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testGRADRaisedPanel()
    {
        foreach (self::$fixTures['testGRADRaisedPanel'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testBarPattern()
    {
        foreach (self::$fixTures['testBarPattern'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testAddingALinePlotToABarGraph()
    {
        foreach (self::$fixTures['testAddingALinePlotToABarGraph'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testExample()
    {
        foreach (self::$fixTures['testExample'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testAdjustingTheWidth()
    {
        foreach (self::$fixTures['testAdjustingTheWidth'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testGroupedAccumulatedBarPlots()
    {
        foreach (self::$fixTures['testGroupedAccumulatedBarPlots'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testExampleOfBarPlotWithAbsoluteLabels()
    {
        foreach (self::$fixTures['testExampleOfBarPlotWithAbsoluteLabels'] as $file) {
            $this->_fileCheck($file);
            # code...
        }
    }

    public function testBAND3dplaneDensity()
    {
        foreach (self::$fixTures['testBAND3dplaneDensity'] as $file) {
            $this->_fileCheck($file);
            # code...
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
