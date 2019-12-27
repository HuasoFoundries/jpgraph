<?php

/**
 * JPGraph v4.0.0
 */

namespace Amenadiel\JpGraph\Text;

use Amenadiel\JpGraph\Util;

/**
 * @class TTF
 * // Description: Handle TTF font names and mapping and loading of
 * //              font files
 */
class TTF extends Configs
{
    private $font_files;
    private $style_names;

    public function __construct()
    {
        // String names for font styles to be used in error messages
        $this->style_names = [
            self::FS_NORMAL     => 'normal',
            self::FS_BOLD       => 'bold',
            self::FS_ITALIC     => 'italic',
            self::FS_BOLDITALIC => 'bolditalic',
        ];

        // File names for available fonts
        $this->font_files = [
            self::FF_COURIER          => [
                self::FS_NORMAL     => 'cour.ttf',
                self::FS_BOLD       => 'courbd.ttf',
                self::FS_ITALIC     => 'couri.ttf',
                self::FS_BOLDITALIC => 'courbi.ttf',
            ],
            self::FF_GEORGIA          => [
                self::FS_NORMAL     => 'georgia.ttf',
                self::FS_BOLD       => 'georgiab.ttf',
                self::FS_ITALIC     => 'georgiai.ttf',
                self::FS_BOLDITALIC => '',
            ],
            self::FF_TREBUCHE         => [
                self::FS_NORMAL     => 'trebuc.ttf',
                self::FS_BOLD       => 'trebucbd.ttf',
                self::FS_ITALIC     => 'trebucit.ttf',
                self::FS_BOLDITALIC => 'trebucbi.ttf',
            ],
            self::FF_VERDANA          => [
                self::FS_NORMAL     => 'verdana.ttf',
                self::FS_BOLD       => 'verdanab.ttf',
                self::FS_ITALIC     => 'verdanai.ttf',
                self::FS_BOLDITALIC => '',
            ],
            self::FF_TIMES            => [
                self::FS_NORMAL     => 'times.ttf',
                self::FS_BOLD       => 'timesbd.ttf',
                self::FS_ITALIC     => 'timesi.ttf',
                self::FS_BOLDITALIC => 'timesbi.ttf',
            ],
            self::FF_COMIC            => [
                self::FS_NORMAL     => 'comic.ttf',
                self::FS_BOLD       => 'comicbd.ttf',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],
            /*self::FF_ARIAL => array(self::FS_NORMAL => 'arial.ttf',
            self::FS_BOLD => 'arialbd.ttf',
            self::FS_ITALIC => 'ariali.ttf',
            self::FS_BOLDITALIC => 'arialbi.ttf'),
             */
            self::FF_ARIAL            => [
                self::FS_NORMAL     => 'arial.ttf',
                self::FS_BOLD       => 'msttcorefonts/Arial_Black.ttf',
                self::FS_ITALIC     => 'ariali.ttf',
                self::FS_BOLDITALIC => 'arialbi.ttf',
            ],
            self::FF_VERA             => [
                self::FS_NORMAL     => 'Vera.ttf',
                self::FS_BOLD       => 'VeraBd.ttf',
                self::FS_ITALIC     => 'VeraIt.ttf',
                self::FS_BOLDITALIC => 'VeraBI.ttf',
            ],
            self::FF_VERAMONO         => [
                self::FS_NORMAL     => 'VeraMono.ttf',
                self::FS_BOLD       => 'VeraMoBd.ttf',
                self::FS_ITALIC     => 'VeraMoIt.ttf',
                self::FS_BOLDITALIC => 'VeraMoBI.ttf',
            ],
            self::FF_VERASERIF        => [
                self::FS_NORMAL     => 'VeraSe.ttf',
                self::FS_BOLD       => 'VeraSeBd.ttf',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            /* Chinese fonts */
            self::FF_SIMSUN           => [
                self::FS_NORMAL     => 'simsun.ttc',
                self::FS_BOLD       => 'simhei.ttf',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],
            self::FF_CHINESE          => [
                self::FS_NORMAL     => self::CHINESE_TTF_FONT,
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],
            self::FF_BIG5             => [
                self::FS_NORMAL     => self::CHINESE_TTF_FONT,
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            /* Japanese fonts */
            self::FF_MINCHO           => [
                self::FS_NORMAL     => self::MINCHO_TTF_FONT,
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            self::FF_PMINCHO          => [
                self::FS_NORMAL     => self::PMINCHO_TTF_FONT,
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            self::FF_GOTHIC           => [
                self::FS_NORMAL     => self::GOTHIC_TTF_FONT,
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            self::FF_PGOTHIC          => [
                self::FS_NORMAL     => self::PGOTHIC_TTF_FONT,
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            /* Hebrew fonts */
            self::FF_DAVID            => [
                self::FS_NORMAL     => 'DAVIDNEW.TTF',
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            self::FF_MIRIAM           => [
                self::FS_NORMAL     => 'MRIAMY.TTF',
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            self::FF_AHRON            => [
                self::FS_NORMAL     => 'ahronbd.ttf',
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            /* Misc fonts */
            self::FF_DIGITAL          => [
                self::FS_NORMAL     => 'DIGIRU__.TTF',
                self::FS_BOLD       => 'Digirtu_.ttf',
                self::FS_ITALIC     => 'Digir___.ttf',
                self::FS_BOLDITALIC => 'DIGIRT__.TTF',
            ],

            /* This is an experimental font for the speedometer development
            self::FF_SPEEDO =>    array(
            self::FS_NORMAL =>'Speedo.ttf',
            self::FS_BOLD =>'',
            self::FS_ITALIC =>'',
            self::FS_BOLDITALIC =>''
            ),
             */

            self::FF_COMPUTER         => [
                self::FS_NORMAL     => 'COMPUTER.TTF',
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            self::FF_CALCULATOR       => [
                self::FS_NORMAL     => 'Triad_xs.ttf',
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            /* Dejavu fonts */
            self::FF_DV_SANSSERIF     => [
                self::FS_NORMAL     => ['DejaVuSans.ttf'],
                self::FS_BOLD       => ['DejaVuSans-Bold.ttf', 'DejaVuSansBold.ttf'],
                self::FS_ITALIC     => ['DejaVuSans-Oblique.ttf', 'DejaVuSansOblique.ttf'],
                self::FS_BOLDITALIC => ['DejaVuSans-BoldOblique.ttf', 'DejaVuSansBoldOblique.ttf'],
            ],

            self::FF_DV_SANSSERIFMONO => [
                self::FS_NORMAL     => ['DejaVuSansMono.ttf', 'DejaVuMonoSans.ttf'],
                self::FS_BOLD       => ['DejaVuSansMono-Bold.ttf', 'DejaVuMonoSansBold.ttf'],
                self::FS_ITALIC     => ['DejaVuSansMono-Oblique.ttf', 'DejaVuMonoSansOblique.ttf'],
                self::FS_BOLDITALIC => ['DejaVuSansMono-BoldOblique.ttf', 'DejaVuMonoSansBoldOblique.ttf'],
            ],

            self::FF_DV_SANSSERIFCOND => [
                self::FS_NORMAL     => ['DejaVuSansCondensed.ttf', 'DejaVuCondensedSans.ttf'],
                self::FS_BOLD       => ['DejaVuSansCondensed-Bold.ttf', 'DejaVuCondensedSansBold.ttf'],
                self::FS_ITALIC     => ['DejaVuSansCondensed-Oblique.ttf', 'DejaVuCondensedSansOblique.ttf'],
                self::FS_BOLDITALIC => ['DejaVuSansCondensed-BoldOblique.ttf', 'DejaVuCondensedSansBoldOblique.ttf'],
            ],

            self::FF_DV_SERIF         => [
                self::FS_NORMAL     => ['DejaVuSerif.ttf'],
                self::FS_BOLD       => ['DejaVuSerif-Bold.ttf', 'DejaVuSerifBold.ttf'],
                self::FS_ITALIC     => ['DejaVuSerif-Italic.ttf', 'DejaVuSerifItalic.ttf'],
                self::FS_BOLDITALIC => ['DejaVuSerif-BoldItalic.ttf', 'DejaVuSerifBoldItalic.ttf'],
            ],

            self::FF_DV_SERIFCOND     => [
                self::FS_NORMAL     => ['DejaVuSerifCondensed.ttf', 'DejaVuCondensedSerif.ttf'],
                self::FS_BOLD       => ['DejaVuSerifCondensed-Bold.ttf', 'DejaVuCondensedSerifBold.ttf'],
                self::FS_ITALIC     => ['DejaVuSerifCondensed-Italic.ttf', 'DejaVuCondensedSerifItalic.ttf'],
                self::FS_BOLDITALIC => ['DejaVuSerifCondensed-BoldItalic.ttf', 'DejaVuCondensedSerifBoldItalic.ttf'],
            ],

            /* Placeholders for defined fonts */
            self::FF_USERFONT1        => [
                self::FS_NORMAL     => '',
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            self::FF_USERFONT2        => [
                self::FS_NORMAL     => '',
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],

            self::FF_USERFONT3        => [
                self::FS_NORMAL     => '',
                self::FS_BOLD       => '',
                self::FS_ITALIC     => '',
                self::FS_BOLDITALIC => '',
            ],
        ];
    }

    /**
     * Encapsulates the logic to check for a file existance
     * If it exists and it's readable, return full path. Otherwise return false.
     *
     * @param <type> $file   The file
     * @param bool   $folder The folder
     *
     * @return bool the full path if exists
     */
    private static function getFullPathIfExists($file, $folder = null)
    {
        $default_path = $folder ? $folder : dirname(self::__DIR__) . '/fonts/';
        $font_path    = sprintf('%s%s%s', $folder, self::DIRECTORY_SEPARATOR, $file);

        if (file_exists($font_path) && is_readable($font_path)) {
            return $font_path;
        }

        return false;
    }

    /**
     * Given a font family and a style, returns the full path to the font
     * Please check your DoxyDoxygen user configuration file.
     *
     * @param mixed  $family    font family (e.g. self::FF_COURIER, self::FF_VERDANA)
     * @param mixed  $style     optional font style, defaults to  self::FS_NORMAL
     * @param string $font_path optional font_path. If set, it takes precedence over other paths
     *
     * @example ` $ttf->File(self::FF_DV_SANSSERIF, self::FS_BOLD); // would return <self::LIBRARY ROOT>/self::src/fonts/DejaVuSans-Bold-ttf
     * ` */
    public function File($family, $style = self::FS_NORMAL, $font_path = null)
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
                Util\JpGraphError::RaiseL(25047, $this->style_names[$style], $this->font_files[$family][self::FS_NORMAL]);
            }
            //('Style "'.$this->style_names[$style].'" is not available for font family '.$this->font_files[$family][self::FS_NORMAL].'.');
            if (!$font_file) {
                Util\JpGraphError::RaiseL(25048, $fam); //("Unknown font style specification [$fam].");
            }

            // check jpgraph/src/fonts dir
            $jpgraph_font_file = $jpgraph_font_dir . $font_file;
            if (file_exists($jpgraph_font_file) === true && is_readable($jpgraph_font_file) === true) {
                $font_file = $jpgraph_font_file;

                break;
            }

            // check OS font dir
            if ($family >= self::FF_MINCHO && $family <= self::FF_PGOTHIC) {
                $font_file = self::MBTTF_DIR . $font_file;
            } else {
                $font_file = self::TTF_DIR . $font_file;
            }
            if (file_exists($font_file) === true && is_readable($font_file) === true) {
                break;
            }
        }

        if (!file_exists($font_file)) {
            //Util\JpGraphError::RaiseL(25049, $font_file); //("Font file \"$font_file\" is not readable or does not exist.");
            return $this->File(self::FF_DV_SANSSERIF, $style);
        }

        return $font_file;
    }

    public function SetUserFont($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[self::FF_USERFONT] =
            [self::FS_NORMAL    => $aNormal,
            self::FS_BOLD       => $aBold,
            self::FS_ITALIC     => $aItalic,
            self::FS_BOLDITALIC => $aBoldIt,
        ];
    }

    public function SetUserFont1($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[self::FF_USERFONT1] =
            [self::FS_NORMAL    => $aNormal,
            self::FS_BOLD       => $aBold,
            self::FS_ITALIC     => $aItalic,
            self::FS_BOLDITALIC => $aBoldIt,
        ];
    }

    public function SetUserFont2($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[self::FF_USERFONT2] =
            [self::FS_NORMAL    => $aNormal,
            self::FS_BOLD       => $aBold,
            self::FS_ITALIC     => $aItalic,
            self::FS_BOLDITALIC => $aBoldIt,
        ];
    }

    public function SetUserFont3($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[self::FF_USERFONT3] =
            [self::FS_NORMAL    => $aNormal,
            self::FS_BOLD       => $aBold,
            self::FS_ITALIC     => $aItalic,
            self::FS_BOLDITALIC => $aBoldIt,
        ];
    }
} // @class
