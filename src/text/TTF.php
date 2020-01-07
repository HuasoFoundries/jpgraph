<?php

/**
 * JPGraph v4.1.0-beta.01
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
            Configs::FS_NORMAL     => 'normal',
            Configs::FS_BOLD       => 'bold',
            Configs::FS_ITALIC     => 'italic',
            Configs::FS_BOLDITALIC => 'bolditalic',
        ];

        // File names for available fonts
        $this->font_files = [
            Configs::FF_COURIER          => [
                Configs::FS_NORMAL     => 'cour.ttf',
                Configs::FS_BOLD       => 'courbd.ttf',
                Configs::FS_ITALIC     => 'couri.ttf',
                Configs::FS_BOLDITALIC => 'courbi.ttf',
            ],
            Configs::FF_GEORGIA          => [
                Configs::FS_NORMAL     => 'georgia.ttf',
                Configs::FS_BOLD       => 'georgiab.ttf',
                Configs::FS_ITALIC     => 'georgiai.ttf',
                Configs::FS_BOLDITALIC => '',
            ],
            Configs::FF_TREBUCHE         => [
                Configs::FS_NORMAL     => 'trebuc.ttf',
                Configs::FS_BOLD       => 'trebucbd.ttf',
                Configs::FS_ITALIC     => 'trebucit.ttf',
                Configs::FS_BOLDITALIC => 'trebucbi.ttf',
            ],
            Configs::FF_VERDANA          => [
                Configs::FS_NORMAL     => 'verdana.ttf',
                Configs::FS_BOLD       => 'verdanab.ttf',
                Configs::FS_ITALIC     => 'verdanai.ttf',
                Configs::FS_BOLDITALIC => '',
            ],
            Configs::FF_TIMES            => [
                Configs::FS_NORMAL     => 'times.ttf',
                Configs::FS_BOLD       => 'timesbd.ttf',
                Configs::FS_ITALIC     => 'timesi.ttf',
                Configs::FS_BOLDITALIC => 'timesbi.ttf',
            ],
            Configs::FF_COMIC            => [
                Configs::FS_NORMAL     => 'comic.ttf',
                Configs::FS_BOLD       => 'comicbd.ttf',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],
            /*Configs::FF_ARIAL => array(Configs::FS_NORMAL => 'arial.ttf',
            Configs::FS_BOLD => 'arialbd.ttf',
            Configs::FS_ITALIC => 'ariali.ttf',
            Configs::FS_BOLDITALIC => 'arialbi.ttf'),
             */
            Configs::FF_ARIAL            => [
                Configs::FS_NORMAL     => 'arial.ttf',
                Configs::FS_BOLD       => 'msttcorefonts/Arial_Black.ttf',
                Configs::FS_ITALIC     => 'ariali.ttf',
                Configs::FS_BOLDITALIC => 'arialbi.ttf',
            ],
            Configs::FF_VERA             => [
                Configs::FS_NORMAL     => 'Vera.ttf',
                Configs::FS_BOLD       => 'VeraBd.ttf',
                Configs::FS_ITALIC     => 'VeraIt.ttf',
                Configs::FS_BOLDITALIC => 'VeraBI.ttf',
            ],
            Configs::FF_VERAMONO         => [
                Configs::FS_NORMAL     => 'VeraMono.ttf',
                Configs::FS_BOLD       => 'VeraMoBd.ttf',
                Configs::FS_ITALIC     => 'VeraMoIt.ttf',
                Configs::FS_BOLDITALIC => 'VeraMoBI.ttf',
            ],
            Configs::FF_VERASERIF        => [
                Configs::FS_NORMAL     => 'VeraSe.ttf',
                Configs::FS_BOLD       => 'VeraSeBd.ttf',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            /* Chinese fonts */
            Configs::FF_SIMSUN           => [
                Configs::FS_NORMAL     => 'simsun.ttc',
                Configs::FS_BOLD       => 'simhei.ttf',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],
            Configs::FF_CHINESE          => [
                Configs::FS_NORMAL     => Configs::CHINESE_TTF_FONT,
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],
            Configs::FF_BIG5             => [
                Configs::FS_NORMAL     => Configs::CHINESE_TTF_FONT,
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            /* Japanese fonts */
            Configs::FF_MINCHO           => [
                Configs::FS_NORMAL     => Configs::MINCHO_TTF_FONT,
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            Configs::FF_PMINCHO          => [
                Configs::FS_NORMAL     => Configs::PMINCHO_TTF_FONT,
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            Configs::FF_GOTHIC           => [
                Configs::FS_NORMAL     => Configs::GOTHIC_TTF_FONT,
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            Configs::FF_PGOTHIC          => [
                Configs::FS_NORMAL     => Configs::PGOTHIC_TTF_FONT,
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            /* Hebrew fonts */
            Configs::FF_DAVID            => [
                Configs::FS_NORMAL     => 'DAVIDNEW.TTF',
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            Configs::FF_MIRIAM           => [
                Configs::FS_NORMAL     => 'MRIAMY.TTF',
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            Configs::FF_AHRON            => [
                Configs::FS_NORMAL     => 'ahronbd.ttf',
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            /* Misc fonts */
            Configs::FF_DIGITAL          => [
                Configs::FS_NORMAL     => 'DIGIRU__.TTF',
                Configs::FS_BOLD       => 'Digirtu_.ttf',
                Configs::FS_ITALIC     => 'Digir___.ttf',
                Configs::FS_BOLDITALIC => 'DIGIRT__.TTF',
            ],

            /* This is an experimental font for the speedometer development
            Configs::FF_SPEEDO =>    array(
            Configs::FS_NORMAL =>'Speedo.ttf',
            Configs::FS_BOLD =>'',
            Configs::FS_ITALIC =>'',
            Configs::FS_BOLDITALIC =>''
            ),
             */

            Configs::FF_COMPUTER         => [
                Configs::FS_NORMAL     => 'COMPUTER.TTF',
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            Configs::FF_CALCULATOR       => [
                Configs::FS_NORMAL     => 'Triad_xs.ttf',
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            /* Dejavu fonts */
            Configs::FF_DV_SANSSERIF     => [
                Configs::FS_NORMAL     => [
                    'DejaVuSans.ttf',
                ],
                Configs::FS_BOLD       => [
                    'DejaVuSans-Bold.ttf', 'DejaVuSansBold.ttf',
                ],
                Configs::FS_ITALIC     => [
                    'DejaVuSans-Oblique.ttf', 'DejaVuSansOblique.ttf',
                ],
                Configs::FS_BOLDITALIC => [
                    'DejaVuSans-BoldOblique.ttf', 'DejaVuSansBoldOblique.ttf',
                ],
            ],

            Configs::FF_DV_SANSSERIFMONO => [
                Configs::FS_NORMAL     => [
                    'DejaVuSansMono.ttf', 'DejaVuMonoSans.ttf',
                ],
                Configs::FS_BOLD       => [
                    'DejaVuSansMono-Bold.ttf', 'DejaVuMonoSansBold.ttf',
                ],
                Configs::FS_ITALIC     => [
                    'DejaVuSansMono-Oblique.ttf', 'DejaVuMonoSansOblique.ttf',
                ],
                Configs::FS_BOLDITALIC => [
                    'DejaVuSansMono-BoldOblique.ttf', 'DejaVuMonoSansBoldOblique.ttf',
                ],
            ],

            Configs::FF_DV_SANSSERIFCOND => [
                Configs::FS_NORMAL     => [
                    'DejaVuSansCondensed.ttf', 'DejaVuCondensedSans.ttf',
                ],
                Configs::FS_BOLD       => [
                    'DejaVuSansCondensed-Bold.ttf', 'DejaVuCondensedSansBold.ttf',
                ],
                Configs::FS_ITALIC     => [
                    'DejaVuSansCondensed-Oblique.ttf', 'DejaVuCondensedSansOblique.ttf',
                ],
                Configs::FS_BOLDITALIC => [
                    'DejaVuSansCondensed-BoldOblique.ttf', 'DejaVuCondensedSansBoldOblique.ttf',
                ],
            ],

            Configs::FF_DV_SERIF         => [
                Configs::FS_NORMAL     => [
                    'DejaVuSerif.ttf',
                ],
                Configs::FS_BOLD       => [
                    'DejaVuSerif-Bold.ttf', 'DejaVuSerifBold.ttf',
                ],
                Configs::FS_ITALIC     => [
                    'DejaVuSerif-Italic.ttf', 'DejaVuSerifItalic.ttf',
                ],
                Configs::FS_BOLDITALIC => [
                    'DejaVuSerif-BoldItalic.ttf', 'DejaVuSerifBoldItalic.ttf',
                ],
            ],

            Configs::FF_DV_SERIFCOND     => [
                Configs::FS_NORMAL     => [
                    'DejaVuSerifCondensed.ttf', 'DejaVuCondensedSerif.ttf',
                ],
                Configs::FS_BOLD       => [
                    'DejaVuSerifCondensed-Bold.ttf', 'DejaVuCondensedSerifBold.ttf',
                ],
                Configs::FS_ITALIC     => [
                    'DejaVuSerifCondensed-Italic.ttf', 'DejaVuCondensedSerifItalic.ttf',
                ],
                Configs::FS_BOLDITALIC => [
                    'DejaVuSerifCondensed-BoldItalic.ttf', 'DejaVuCondensedSerifBoldItalic.ttf',
                ],
            ],

            /* Placeholders for defined fonts */
            Configs::FF_USERFONT1        => [
                Configs::FS_NORMAL     => '',
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            Configs::FF_USERFONT2        => [
                Configs::FS_NORMAL     => '',
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
            ],

            Configs::FF_USERFONT3        => [
                Configs::FS_NORMAL     => '',
                Configs::FS_BOLD       => '',
                Configs::FS_ITALIC     => '',
                Configs::FS_BOLDITALIC => '',
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
        //kdump($full_path);

        if (file_exists($full_path) && is_readable($full_path)) {
            return $full_path;
        }
        return false;
    }

    /**
     * Given a font family and a style, returns the full path to the font
     * Please check your DoxyDoxygen user configuration file.
     *
     * @param mixed  $family    font family (e.g. Configs::FF_COURIER, Configs::FF_VERDANA)
     * @param mixed  $style     optional font style, defaults to  Configs::FS_NORMAL
     * @param string $font_path optional font_path. If set, it takes precedence over other paths
     *
     * @example ` $ttf->File(Configs::FF_DV_SANSSERIF, Configs::FS_BOLD); // would return <self::LIBRARY ROOT>/self::src/fonts/DejaVuSans-Bold-ttf
     * ` */
    public function File($family, $style = Configs::FS_NORMAL, $font_path = null)
    {
        $font_translation = null;
        $fam              = @$this->font_files[$family];
        if (array_key_exists($family, Configs::$font_dict) &&
            array_key_exists($style, Configs::$font_dict)
            // && !array_key_exists($family,$this->font_files)
        ) {
            $font_translation = sprintf('%s::%s',
                Configs::$font_dict[$family],
                Configs::$font_dict[$style]
            );
            if (array_key_exists($font_translation, Configs::$FOUND_FONTS)) {
                return Configs::$FOUND_FONTS[$font_translation];
            }

        }
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
                Util\JpGraphError::RaiseL(25047, $this->style_names[$style], $this->font_files[$family][Configs::FS_NORMAL]);
            }
            //('Style "'.$this->style_names[$style].'" is not available for font family '.$this->font_files[$family][Configs::FS_NORMAL].'.');
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
            if ($family >= Configs::FF_MINCHO && $family <= Configs::FF_PGOTHIC) {
                $font_file = Configs::MBTTF_DIR . $font_file;
            } else {
                $font_file = Configs::TTF_DIR . $font_file;
            }
            if (file_exists($font_file) === true && is_readable($font_file) === true) {
                break;
            }
        }

        if (!file_exists($font_file)) {
            //Util\JpGraphError::RaiseL(25049, $font_file); //("Font file \"$font_file\" is not readable or does not exist.");
            // Fallback to FF_DV_SANSSERIF
            // which is DejaVuSans in Ubuntu
            $font_file = $this->File(Configs::FF_DV_SANSSERIF, $style);
        }
        // Try to use the canonical path
        if (is_readable(realpath($font_file))) {
            $font_file = realpath($font_file);
        }
        if ($font_translation) {
            // Will store found font to skip next search
            Configs::$FOUND_FONTS[$font_translation] = $font_file;
            /*kdump([
        'family'      => sprintf('%s (%d)', Configs::$font_dict[$family], $family),
        'style'       => sprintf('%s (%d)', Configs::$font_dict[$style], $style),
        'ff'          => $fam[$style],
        'FOUND_FONTS' => Configs::$FOUND_FONTS,
        ]);*/
        }
        return $font_file;
    }

    public function SetUserFont($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[Configs::FF_USERFONT] =
            [
            Configs::FS_NORMAL     => $aNormal,
            Configs::FS_BOLD       => $aBold,
            Configs::FS_ITALIC     => $aItalic,
            Configs::FS_BOLDITALIC => $aBoldIt,
        ];
    }

    public function SetUserFont1($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[Configs::FF_USERFONT1] =
            [
            Configs::FS_NORMAL     => $aNormal,
            Configs::FS_BOLD       => $aBold,
            Configs::FS_ITALIC     => $aItalic,
            Configs::FS_BOLDITALIC => $aBoldIt,
        ];
    }

    public function SetUserFont2($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[Configs::FF_USERFONT2] =
            [
            Configs::FS_NORMAL     => $aNormal,
            Configs::FS_BOLD       => $aBold,
            Configs::FS_ITALIC     => $aItalic,
            Configs::FS_BOLDITALIC => $aBoldIt,
        ];
    }

    public function SetUserFont3($aNormal, $aBold = '', $aItalic = '', $aBoldIt = '')
    {
        $this->font_files[Configs::FF_USERFONT3] =
            [
            Configs::FS_NORMAL     => $aNormal,
            Configs::FS_BOLD       => $aBold,
            Configs::FS_ITALIC     => $aItalic,
            Configs::FS_BOLDITALIC => $aBoldIt,
        ];
    }
}

// @class
