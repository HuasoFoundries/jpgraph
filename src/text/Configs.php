<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Text;

use Amenadiel\JpGraph\Util;

// Require ../Util/Config.php
require_once \sprintf(
    '%s%s..%sutil%sConfigs.php',
    __DIR__,
    \DIRECTORY_SEPARATOR,
    \DIRECTORY_SEPARATOR,
    \DIRECTORY_SEPARATOR
);

class Configs extends Util\Configs
{
    const TGRID_SINGLE = 1;
    const TGRID_DOUBLE = 2;
    const TGRID_DOUBLE2 = 3;

    // Type of constrain for image constrain
    const TIMG_WIDTH = 1;
    const TIMG_HEIGHT = 2;
    // Width of tab titles
    const TABTITLE_WIDTHFIT = 0;
    const TABTITLE_WIDTHFULL = -1;
    // TTF Font styles
    const FS_NORMAL = 9001;
    const FS_BOLD = 9002;
    const FS_ITALIC = 9003;
    const FS_BOLDIT = 9004;
    const FS_BOLDITALIC = 9004;

    const FF_DEFAULT = 47;
    const FF_AHRON = 46;
    const FF_ARIAL = 15;
    const FF_BIG5 = 32;
    const FF_COMIC = 14;
    const FF_COMPUTER = 73;
    const FF_COURIER = 10;
    const FF_DAVID = 44;
    const FF_DV_SANSSERIFCOND = 51;
    const FF_DV_SANSSERIFMONO = 49;
    const FF_DV_SERIF = 48;
    const FF_DV_SERIFCOND = 50;
    const FF_FONT0 = 1;
    const FF_FONT1 = 2;
    const FF_FONT2 = 4;
    const FF_GEORGIA = 16;
    const FF_GOTHIC = 42;
    const FF_MINCHO = 40;
    const FF_MIRIAM = 45;
    const FF_PGOTHIC = 43;
    const FF_PMINCHO = 41;
    const FF_SIMSUN = 30;
    const FF_TIMES = 12;
    const FF_TREBUCHE = 17;
    const FF_USERFONT = 90;
    const FF_USERFONT1 = 90;
    const FF_USERFONT2 = 91;
    const FF_USERFONT3 = 92;
    const FF_VERA = 18;
    const FF_VERAMONO = 19;
    const FF_VERASERIF = 20;
    const FF_VERDANA = 11;
    const FF_CALCULATOR = 74;
    const FF_CHINESE = 31;
    const FF_DIGITAL = 72;
    const FF_DV_SANSSERIF = self::FF_DEFAULT;

    /*
     * Defines for font setup
     */
    // Actual name of the TTF file used together with FF_CHINESE aka FF_BIG5
    // This is the TTF file being used when the font family is specified as
    // either FF_CHINESE or FF_BIG5
    const CHINESE_TTF_FONT = 'bkai00mp.ttf';

    // Special unicode greek language support
    const LANGUAGE_GREEK = false;

    // If you are setting this config to true the conversion of greek characters
    // will assume that the input text is windows 1251
    const GREEK_FROM_WINDOWS = false;

    // Special unicode cyrillic language support
    const LANGUAGE_CYRILLIC = false;

    // If you are setting this config to true the conversion
    // will assume that the input text is windows 1251, if
    // false it will assume koi8-r
    const CYRILLIC_FROM_WINDOWS = false;

    // The following constant is used to auto-detect
    // whether cyrillic conversion is really necessary
    // if enabled. Just replace 'windows-1251' with a variable
    // containing the input character encoding string
    // of your application calling jpgraph.
    // A typical such string would be 'UTF-8' or 'utf-8'.
    // The comparison is case-insensitive.
    // If this charset is not a 'koi8-r' or 'windows-1251'
    // derivate then no conversion is done.
    //
    // This constant can be very important in multi-user
    // multi-language environments where a cyrillic conversion
    // could be needed for some cyrillic people
    // and resulting in just erraneous conversions
    // for not-cyrillic language based people.
    //
    // Example: In the free project management
    // software dotproject.net $locale_char_set is dynamically
    // set by the language environment the user has chosen.
    //
    // Usage: const LANGUAGE_CHARSET= $locale_char_set;
    //
    // where $locale_char_set is a GLOBAL (string) variable
    // from the application including JpGraph.
    const LANGUAGE_CHARSET = null;
    // Assume that Japanese text have been entered in EUC-JP encoding.
    // If this define is true then conversion from EUC-JP to UTF8 is done
    // automatically in the library using the mbstring module in PHP.
    const ASSUME_EUCJP_ENCODING = false;
    // Japanese TrueType font used with FF_MINCHO, FF_PMINCHO, FF_GOTHIC, FF_PGOTHIC
    // Standard fonts from Infomation-technology Promotion Agency (IPA)
    // See http://mix-mplus-ipa.sourceforge.jp/
    const MINCHO_TTF_FONT = 'ipam.ttf';
    const PMINCHO_TTF_FONT = 'ipamp.ttf';
    const GOTHIC_TTF_FONT = 'ipag.ttf';
    const PGOTHIC_TTF_FONT = 'ipagp.ttf';

    /**
     * I had to do this because it's impossible to debug otherwise.
     *
     * @var array
     */
    public static $font_dict = [
        //Configs::FF_SPEEDO           => 'FF_SPEEDO',
        self::FF_AHRON => 'FF_AHRON',
        self::FF_ARIAL => 'FF_ARIAL',
        self::FF_BIG5 => 'FF_BIG5',
        self::FF_CALCULATOR => 'FF_CALCULATOR',
        self::FF_CHINESE => 'FF_CHINESE',
        self::FF_COMIC => 'FF_COMIC',
        self::FF_COMPUTER => 'FF_COMPUTER',
        self::FF_COURIER => 'FF_COURIER',
        self::FF_DAVID => 'FF_DAVID',
        self::FF_DIGITAL => 'FF_DIGITAL',
        self::FF_DV_SANSSERIF => 'FF_DV_SANSSERIF',
        self::FF_DV_SANSSERIFCOND => 'FF_DV_SANSSERIFCOND',
        self::FF_DV_SANSSERIFMONO => 'FF_DV_SANSSERIFMONO',
        self::FF_DV_SERIF => 'FF_DV_SERIF',
        self::FF_DV_SERIFCOND => 'FF_DV_SERIFCOND',
        self::FF_FONT0 => 'FF_FONT0',
        self::FF_FONT1 => 'FF_FONT1',
        self::FF_FONT2 => 'FF_FONT2',
        self::FF_GEORGIA => 'FF_GEORGIA',
        self::FF_GOTHIC => 'FF_GOTHIC',
        self::FF_MINCHO => 'FF_MINCHO',
        self::FF_MIRIAM => 'FF_MIRIAM',
        self::FF_PGOTHIC => 'FF_PGOTHIC',
        self::FF_PMINCHO => 'FF_PMINCHO',
        self::FF_SIMSUN => 'FF_SIMSUN',
        self::FF_TIMES => 'FF_TIMES',
        self::FF_TREBUCHE => 'FF_TREBUCHE',
        self::FF_USERFONT => 'FF_USERFONT',
        self::FF_USERFONT1 => 'FF_USERFONT1',
        self::FF_USERFONT2 => 'FF_USERFONT2',
        self::FF_USERFONT3 => 'FF_USERFONT3',
        self::FF_VERA => 'FF_VERA',
        self::FF_VERAMONO => 'FF_VERAMONO',
        self::FF_VERASERIF => 'FF_VERASERIF',
        self::FF_VERDANA => 'FF_VERDANA',
        self::FS_BOLD => 'FS_BOLD',
        self::FS_BOLDITALIC => 'FS_BOLDITALIC',
        self::FS_ITALIC => 'FS_ITALIC',
        self::FS_NORMAL => 'FS_NORMAL',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
