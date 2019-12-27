<?php
use \Codeception\Util\Debug;

/**
 * @group ready
 */
class ImgTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures = [
        'testfileIterator'                => [
            'antispamex01.php',
            'imgmarkerex1.php'],
        'testUsingACountryFlagBackground' => [
            'bkgimgflagex1.php',
        ],

        'testVerticallySkewedImages'      => [

            'bkgimgflagex2.php' => ['width' => 300, 'height' => 53, 'filename' => 'bkgimgflagex2.php'],
            'bkgimgflagex3.php' => ['width' => 300, 'height' => 53, 'filename' => 'bkgimgflagex3.php'],
        ],

        'testHorizontallySkewedImages'    => [
            'bkgimgflagex4.php' => ['width' => 170, 'height' => 200, 'filename' => 'bkgimgflagex4.php'],
            'bkgimgflagex5.php' => ['width' => 170, 'height' => 200, 'filename' => 'bkgimgflagex5.php'],
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
        //Debug::debug($knownFixtures);
        self::$files = array_filter(self::$files, function ($filename) use ($knownFixtures) {
            return !array_key_exists($filename, $knownFixtures);
        });

        // Debug::debug(__CLASS__ . ' has ' . count(self::$files) . ' files');

    }

    protected function _before() {}

    protected function _after() {}

    public function testHorizontallySkewedImages()
    {
        foreach (self::$fixTures['testHorizontallySkewedImages'] as $file => $dims) {

            $this->_fileCheck($file, self::$ranTests, false, $dims);
        }
    }

    public function testUsingACountryFlagBackground()
    {
        foreach (self::$fixTures['testUsingACountryFlagBackground'] as $file) {
            $this->_fileCheck($file, self::$ranTests, false);
        }
    }

    public function testVerticallySkewedImages()
    {
        foreach (self::$fixTures['testVerticallySkewedImages'] as $file => $dims) {

            $this->_fileCheck($file, self::$ranTests, false, $dims);
        }
    }

    private function _fileCheck($filename, &$ownFixtures = [], $debug = false, $dims = [])
    {

        $example_title = 'file_iterator';
        ob_start();

        include self::$exampleRoot . $filename;

        $img  = (ob_get_clean());
        $size = getimagesizefromstring($img);

        $size['filename'] = $filename;
        if (array_key_exists('width', $dims) && array_key_exists('height', $dims)) {
            $__width  = $dims['width'];
            $__height = $dims['height'];
        }

        if (!isset($__width) || !isset($__height)) {
            Debug::debug(
                'testing ' . $filename .
                ' for image/jpeg headers ');
            $this->assertEquals('image/jpeg', $size['mime'], 'image should have mime image/jpeg for ' . $filename);
        } else {
            Debug::debug(
                'testing ' . $filename .
                ' for dims ' . implode('x', [$__width, $__height]));
            $this->assertEquals($__width, $size[0], 'width should match the one declared for ' . $filename);
            $this->assertEquals($__height, $size[1], 'height should match the one declared for ' . $filename);
        }
        return $this->_normalizeTestGroup($filename, $ownFixtures, $example_title, $debug);
    }

    public function testFileIterator()
    {
        self::$genericFixtures = array_reduce(self::$fixTures['testfileIterator'], function ($carry, $file) {
            $carry = $this->_fileCheck($file, $carry);
            return $carry;
        }, self::$genericFixtures);

    }
}
