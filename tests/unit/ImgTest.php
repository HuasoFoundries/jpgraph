<?php
/**
 * @group ready
 */
class ImgTest extends \Codeception\Test\Unit
{
    public static $files       = null;
    public static $exampleRoot = null;

    public static function setUpBeforeClass()
    {
        $className         = str_replace('test', '', strtolower(__CLASS__));
        self::$exampleRoot = getRoot($className);
        self::$files       = GetFiles(self::$exampleRoot);
        \Codeception\Util\Debug::debug(__CLASS__ . ' has ' . count(self::$files) . ' files');
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testFile0()
    {
        $filename = array_pop(self::$files);
        $this->_fileCheck($filename, __METHOD__);
    }

    public function testFile1()
    {
        $filename = array_pop(self::$files);
        $this->_fileCheck($filename, __METHOD__);
    }

    private function _fileCheck($filename, $from)
    {
        \Codeception\Util\Debug::debug('after ' . $from . ' ' . __CLASS__ . ' has ' . count(self::$files) . ' files left');
        ob_start();
        include self::$exampleRoot . $filename;
        $img  = (ob_get_clean());
        $size = getimagesizefromstring($img);

        $size['filename'] = $filename;
        if (!isset($__width) || !isset($__height)) {
            $this->assertEquals('image/jpeg', $size['mime'], 'image should have mime image/jpeg for ' . $filename);
        } elseif ($__width != $size[0] || $__height != $size[1]) {
            rename(self::$exampleRoot . $filename, self::$exampleRoot . 'no_dim_' . $filename);
        } else {
            $this->assertEquals($__width, $size[0], 'width should match the one declared for ' . $filename);
            $this->assertEquals($__height, $size[1], 'height should match the one declared for ' . $filename);
        }
    }

    public function testFileIterator()
    {
        while (count(self::$files)) {
            $filename = array_pop(self::$files);
            $this->_fileCheck($filename, __METHOD__);
        }
    }
}
