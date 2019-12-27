<?php

use \Amenadiel\JpGraph\Util\Configs;
use \Codeception\Util\Debug;

class MockTest extends \Codeception\Test\Unit
{
    use Amenadiel\JpGraph\UnitTest\UnitTestTrait;

    public static $fixTures    = [];
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];

    public static function setUpBeforeClass(): void
    {
        $className = str_replace('test', '', strtolower(__CLASS__));
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testOneIsOne()
    {
        Debug::debug(['BAND_RDIAG'     => Configs::BAND_RDIAG,
            'BAND_LDIAG'               => Configs::BAND_LDIAG,
            'BAND_SOLID'               => Configs::BAND_SOLID,
            'BAND_VLINE'               => Configs::BAND_VLINE,
            'BAND_HLINE'               => Configs::BAND_HLINE,
            'BAND_3DPLANE'             => Configs::BAND_3DPLANE,
            'BAND_HVCROSS'             => Configs::BAND_HVCROSS,
            'BAND_DIAGCROSS'           => Configs::BAND_DIAGCROSS,
        ]);
        $this->assertEquals(1, 1, 'meaningless test ');
    }
};
