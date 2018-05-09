<?php
/**
 * @group ready
 */
class BackgroundTest extends \Codeception\Test\Unit
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

    private function _fileCheck($filename)
    {
        ob_start();

        include self::$exampleRoot . $filename;

        $img = (ob_get_clean());

        $size = getimagesizefromstring($img);

        $size['filename'] = $filename;
        if ($__width != $size[0] || $__height != $size[1]) {
            rename(self::$exampleRoot . $filename, self::$exampleRoot . 'no_dim_' . $filename);
        }
        $this->assertEquals($__width, $size[0], 'width should match the one declared for ' . $filename);
        $this->assertEquals($__height, $size[1], 'height should match the one declared for ' . $filename);
    }

    public function testFileIterator()
    {
        foreach (self::$files as $file) {
            $this->_fileCheck($file);
        }
    }
}
