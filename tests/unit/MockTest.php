<?php

use \Codeception\Util\Debug;

class MockTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures    = [];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];

    public static function setUpBeforeClass()
    {
        $className = str_replace('test', '', strtolower(__CLASS__));

    }

    protected function _before() {}

    protected function _after() {}

    public function testOneIsOne()
    {
        $constants = new \Amenadiel\JpGraph\Util\Constants();
        Debug::debug(['BAND_RDIAG' => BAND_RDIAG,
            'BAND_LDIAG'               => BAND_LDIAG,
            'BAND_SOLID'               => BAND_SOLID,
            'BAND_VLINE'               => BAND_VLINE,
            'BAND_HLINE'               => BAND_HLINE,
            'BAND_3DPLANE'             => BAND_3DPLANE,
            'BAND_HVCROSS'             => BAND_HVCROSS,
            'BAND_DIAGCROSS'           => BAND_DIAGCROSS,
        ]);
        $this->assertEquals(1, 2, 'meaningless test ');

    }
};
