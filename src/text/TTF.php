<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Text;

use Amenadiel\JpGraph\Util;

/**
 * @class TTF
 * // Description: Handle TTF font names and mapping and loading of
 * //              font files
 */
class TTF
{
    private $font_files;
    private $style_names;
    public static $FONT_BASEPATH;

    public function __construct()
    {
        self::$FONT_BASEPATH = getenv('JPGRAPH_FONT_BASEPATH') ?
        getenv('JPGRAPH_FONT_BASEPATH') :
        dirname(__DIR__) . '/fonts/';
        // String names for font styles to be used in error messages
        $this->style_names = [
            FS_NORMAL     => 'normal',
            FS_BOLD       => 'bold',
            FS_ITALIC     => 'italic',
            FS_BOLDITALIC => 'bolditalic',
        ];

        // File names for available fonts
        $this->font_files = [
            FF_COURIER          => [
                FS_NORMAL     => 'cour.ttf',
                FS_BOLD       => 'courbd.ttf',
                FS_ITALIC     => 'couri.ttf',
                FS_BOLDITALIC => 'courbi.ttf',
            ],
            FF_GEORGIA          => [
                FS_NORMAL     => 'georgia.ttf',
                FS_BOLD       => 'georgiab.ttf',
                FS_ITALIC     => 'georgiai.ttf',
                FS_BOLDITALIC => '',
            ],
            FF_TREBUCHE         => [
                FS_NORMAL     => 'trebuc.ttf',
                FS_BOLD       => 'trebucbd.ttf',
                FS_ITALIC     => 'trebucit.ttf',
                FS_BOLDITALIC => 'trebucbi.ttf',
            ],
            FF_VERDANA          => [
                FS_NORMAL     => 'verdana.ttf',
                FS_BOLD       => 'verdanab.ttf',
                FS_ITALIC     => 'verdanai.ttf',
                FS_BOLDITALIC => '',
            ],
            FF_TIMES            => [
                FS_NORMAL     => 'times.ttf',
                FS_BOLD       => 'timesbd.ttf',
                FS_ITALIC     => 'timesi.ttf',
                FS_BOLDITALIC => 'timesbi.ttf',
            ],
            FF_COMIC            => [
                FS_NORMAL     => 'comic.ttf',
                FS_BOLD       => 'comicbd.ttf',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],
            /*FF_ARIAL => array(FS_NORMAL => 'arial.ttf',
            FS_BOLD => 'arialbd.ttf',
            FS_ITALIC => 'ariali.ttf',
            FS_BOLDITALIC => 'arialbi.ttf'),
             */
            FF_ARIAL            => [
                FS_NORMAL     => 'arial.ttf',
                FS_BOLD       => 'msttcorefonts/Arial_Black.ttf',
                FS_ITALIC     => 'ariali.ttf',
                FS_BOLDITALIC => 'arialbi.ttf',
            ],
            FF_VERA             => [
                FS_NORMAL     => 'Vera.ttf',
                FS_BOLD       => 'VeraBd.ttf',
                FS_ITALIC     => 'VeraIt.ttf',
                FS_BOLDITALIC => 'VeraBI.ttf',
            ],
            FF_VERAMONO         => [
                FS_NORMAL     => 'VeraMono.ttf',
                FS_BOLD       => 'VeraMoBd.ttf',
                FS_ITALIC     => 'VeraMoIt.ttf',
                FS_BOLDITALIC => 'VeraMoBI.ttf',
            ],
            FF_VERASERIF        => [
                FS_NORMAL     => 'VeraSe.ttf',
                FS_BOLD       => 'VeraSeBd.ttf',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            /* Chinese fonts */
            FF_SIMSUN           => [
                FS_NORMAL     => 'simsun.ttc',
                FS_BOLD       => 'simhei.ttf',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],
            FF_CHINESE          => [
                FS_NORMAL     => CHINESE_TTF_FONT,
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],
            FF_BIG5             => [
                FS_NORMAL     => CHINESE_TTF_FONT,
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            /* Japanese fonts */
            FF_MINCHO           => [
                FS_NORMAL     => MINCHO_TTF_FONT,
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            FF_PMINCHO          => [
                FS_NORMAL     => PMINCHO_TTF_FONT,
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            FF_GOTHIC           => [
                FS_NORMAL     => GOTHIC_TTF_FONT,
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            FF_PGOTHIC          => [
                FS_NORMAL     => PGOTHIC_TTF_FONT,
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            /* Hebrew fonts */
            FF_DAVID            => [
                FS_NORMAL     => 'DAVIDNEW.TTF',
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            FF_MIRIAM           => [
                FS_NORMAL     => 'MRIAMY.TTF',
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            FF_AHRON            => [
                FS_NORMAL     => 'ahronbd.ttf',
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            /* Misc fonts */
            FF_DIGITAL          => [
                FS_NORMAL     => 'DIGIRU__.TTF',
                FS_BOLD       => 'Digirtu_.ttf',
                FS_ITALIC     => 'Digir___.ttf',
                FS_BOLDITALIC => 'DIGIRT__.TTF',
            ],

            /* This is an experimental font for the speedometer development
            FF_SPEEDO =>    array(
            FS_NORMAL =>'Speedo.ttf',
            FS_BOLD =>'',
            FS_ITALIC =>'',
            FS_BOLDITALIC =>''
            ),
             */

            FF_COMPUTER         => [
                FS_NORMAL     => 'COMPUTER.TTF',
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            FF_CALCULATOR       => [
                FS_NORMAL     => 'Triad_xs.ttf',
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            /* Dejavu fonts */
            FF_DV_SANSSERIF     => [
                FS_NORMAL     => ['DejaVuSans.ttf'],
                FS_BOLD       => ['DejaVuSans-Bold.ttf', 'DejaVuSansBold.ttf'],
                FS_ITALIC     => ['DejaVuSans-Oblique.ttf', 'DejaVuSansOblique.ttf'],
                FS_BOLDITALIC => ['DejaVuSans-BoldOblique.ttf', 'DejaVuSansBoldOblique.ttf'],
            ],

            FF_DV_SANSSERIFMONO => [
                FS_NORMAL     => ['DejaVuSansMono.ttf', 'DejaVuMonoSans.ttf'],
                FS_BOLD       => ['DejaVuSansMono-Bold.ttf', 'DejaVuMonoSansBold.ttf'],
                FS_ITALIC     => ['DejaVuSansMono-Oblique.ttf', 'DejaVuMonoSansOblique.ttf'],
                FS_BOLDITALIC => ['DejaVuSansMono-BoldOblique.ttf', 'DejaVuMonoSansBoldOblique.ttf'],
            ],

            FF_DV_SANSSERIFCOND => [
                FS_NORMAL     => ['DejaVuSansCondensed.ttf', 'DejaVuCondensedSans.ttf'],
                FS_BOLD       => ['DejaVuSansCondensed-Bold.ttf', 'DejaVuCondensedSansBold.ttf'],
                FS_ITALIC     => ['DejaVuSansCondensed-Oblique.ttf', 'DejaVuCondensedSansOblique.ttf'],
                FS_BOLDITALIC => ['DejaVuSansCondensed-BoldOblique.ttf', 'DejaVuCondensedSansBoldOblique.ttf'],
            ],

            FF_DV_SERIF         => [
                FS_NORMAL     => ['DejaVuSerif.ttf'],
                FS_BOLD       => ['DejaVuSerif-Bold.ttf', 'DejaVuSerifBold.ttf'],
                FS_ITALIC     => ['DejaVuSerif-Italic.ttf', 'DejaVuSerifItalic.ttf'],
                FS_BOLDITALIC => ['DejaVuSerif-BoldItalic.ttf', 'DejaVuSerifBoldItalic.ttf'],
            ],

            FF_DV_SERIFCOND     => [
                FS_NORMAL     => ['DejaVuSerifCondensed.ttf', 'DejaVuCondensedSerif.ttf'],
                FS_BOLD       => ['DejaVuSerifCondensed-Bold.ttf', 'DejaVuCondensedSerifBold.ttf'],
                FS_ITALIC     => ['DejaVuSerifCondensed-Italic.ttf', 'DejaVuCondensedSerifItalic.ttf'],
                FS_BOLDITALIC => ['DejaVuSerifCondensed-BoldItalic.ttf', 'DejaVuCondensedSerifBoldItalic.ttf'],
            ],

            /* Placeholders for defined fonts */
            FF_USERFONT1        => [
                FS_NORMAL     => '',
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            FF_USERFONT2        => [
                FS_NORMAL     => '',
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],

            FF_USERFONT3        => [
                FS_NORMAL     => '',
                FS_BOLD       => '',
                FS_ITALIC     => '',
                FS_BOLDITALIC => '',
            ],
        ];
    }

    /**
     * Encapsulates the logic to check for a file existance
     * If it exists and it's readable, return full path. Otherwise return false.
     *
     * @param <type> $file      The file
     * @param bool   $folder    The folder
     * @param mixed  $font_file
     * @param mixed  $font_path
     *
     * @return bool the full path if exists
     */
    private static function getFullPathIfExists($font_file, $font_path = '')
    {
        $full_path = sprintf('%s%s', $font_path, $font_file);

        if (file_exists($full_path) && is_readable($full_path)) {
            return $full_path;
        }
        // kdump('Not found: ' . $font_path);
        return false;
    }

    /**
     * Given a font family and a style, returns the full path to the font
     * Please check your DoxyDoxygen user configuration file.
     *
     * @param mixed  $family    font family (e.g. FF_COURIER, FF_VERDANA)
     * @param mixed  $style     optional font style, defaults to  FS_NORMAL
     * @param string $font_path optional font_path. If set, it takes precedence over other paths
     *
     * @example ` $ttf->File(FF_DV_SANSSERIF, FS_BOLD); // would return <self::LIBRARY ROOT>/self::src/fonts/DejaVuSans-Bold-ttf
     * ` */
    public function File($family, $style = FS_NORMAL, $font_path = null)
    {
        $fam = @$this->font_files[$family];
        if (!$fam) {
            Util\JpGraphError::RaiseL(25046, $family); //("Specified TTF font family (id=$family) is unknown or does not exist. Please note that TTF fonts are not distributed with JpGraph for copyright reasons. You can find the MS TTF WEB-fonts (arial, courier etc) for download at http://corefonts.sourceforge.net/");
        }
        $ff = @$fam[$style];

        // There are several optional file names. They are tried in order
        // and the first one found is used
        if (!is_array($ff)) {
            $ff = [$ff];
        }

        $jpgraph_font_dir = dirname(dirname(__FILE__)) . '/fonts/';

        foreach ($ff as $font_file) {
            // All font families are guaranteed to have the normal style

            if ($font_file === '') {
                Util\JpGraphError::RaiseL(25047, $this->style_names[$style], $this->font_files[$family][FS_NORMAL]);
            }
            //('Style "'.$this->style_names[$style].'" is not available for font family '.$this->font_files[$family][FS_NORMAL].'.');
            if (!$font_file) {
                Util\JpGraphError::RaiseL(25048, $fam); //("Unknown font style specification [$fam].");
            }

            if ($font_candidate = self::getFullPathIfExists($font_file, $font_path)) {
                $font_file = $font_candidate;

                break;
            }
            if ($font_candidate = self::getFullPathIfExists($font_file, self::$FONT_BASEPATH)) {
                $font_file = $font_candidate;

                break;
            }

            // check OS font dir
            if ($family >= FF_MINCHO && $family <= FF_PGOTHIC) {
                $font_file = MBTTF_DIR . $font_file;
            } else {
                $font_file = TTF_DIR . $font_file;
            }
            if (file_exists($font_file) === true && is_readable($font_file) === true) {
                break;
            }
        }

        if (!file_exists($font_file)) {
            //Util\JpGraphError::RaiseL(25049, $font_file); //("Font file \"$font_file\" is not readable or does not exist.");
            return $this->File(FF_DV_SANSSERIF, $style);
        }

        return $font_file;
    }

    public function SetUserFont($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[FF_USERFONT] =
            [FS_NORMAL    => $aNormal,
            FS_BOLD       => $aBold,
            FS_ITALIC     => $aItalic,
            FS_BOLDITALIC => $aBoldIt,
        ];
    }

    public function SetUserFont1($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[FF_USERFONT1] =
            [FS_NORMAL    => $aNormal,
            FS_BOLD       => $aBold,
            FS_ITALIC     => $aItalic,
            FS_BOLDITALIC => $aBoldIt,
        ];
    }

    public function SetUserFont2($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[FF_USERFONT2] =
            [FS_NORMAL    => $aNormal,
            FS_BOLD       => $aBold,
            FS_ITALIC     => $aItalic,
            FS_BOLDITALIC => $aBoldIt,
        ];
    }

    public function SetUserFont3($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[FF_USERFONT3] =
            [FS_NORMAL    => $aNormal,
            FS_BOLD       => $aBold,
            FS_ITALIC     => $aItalic,
            FS_BOLDITALIC => $aBoldIt,
        ];
    }
} // @class
