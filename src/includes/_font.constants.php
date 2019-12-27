<?php

/**
 * JPGraph v4.0.0
 */

// TTF Font families
define('FF_COURIER', 10);
define('FF_VERDANA', 11);
define('FF_TIMES', 12);
define('FF_COMIC', 14);
define('FF_ARIAL', 15);
define('FF_GEORGIA', 16);
define('FF_TREBUCHE', 17);

// Gnome Vera font
// Available from http://www.gnome.org/fonts/
define('FF_VERA', 18);
define('FF_VERAMONO', 19);
define('FF_VERASERIF', 20);

// Chinese font
define('FF_SIMSUN', 30);
define('FF_CHINESE', 31);
define('FF_BIG5', 32);

// Japanese font
define('FF_MINCHO', 40);
define('FF_PMINCHO', 41);
define('FF_GOTHIC', 42);
define('FF_PGOTHIC', 43);

// Hebrew fonts
define('FF_DAVID', 44);
define('FF_MIRIAM', 45);
define('FF_AHRON', 46);

// Dejavu-fonts http://sourceforge.net/projects/dejavu
define('FF_DV_SANSSERIF', 47);
define('FF_DV_SERIF', 48);
define('FF_DV_SANSSERIFMONO', 49);
define('FF_DV_SERIFCOND', 50);
define('FF_DV_SANSSERIFCOND', 51);

// Extra fonts
// Download fonts from
// http://www.webfontlist.com
// http://www.webpagepublicity.com/free-fonts.html
// http://www.fontonic.com/fonts.asp?width=d&offset=120
// http://www.fontspace.com/category/famous

// define("FF_SPEEDO",71);  // This font is also known as Bauer (Used for development gauge fascia)
define('FF_DIGITAL', 72); // Digital readout font
define('FF_COMPUTER', 73); // The classic computer font
define('FF_CALCULATOR', 74); // Triad font

define('FF_USERFONT', 90);
define('FF_USERFONT1', 90);
define('FF_USERFONT2', 91);
define('FF_USERFONT3', 92);

// Limits for fonts

// TTF Font styles
define('FS_NORMAL', 9001);
define('FS_BOLD', 9002);
define('FS_ITALIC', 9003);
define('FS_BOLDIT', 9004);
define('FS_BOLDITALIC', 9004);

//Definitions for internal font
define('FF_FONT0', 1);
define('FF_FONT1', 2);
define('FF_FONT2', 4);

/*
 * Defines for font setup
 */
// Actual name of the TTF file used together with Configs::FF_CHINESE aka Configs::FF_BIG5
// This is the TTF file being used when the font family is specified as
// either Configs::FF_CHINESE or Configs::FF_BIG5
define('CHINESE_TTF_FONT', 'bkai00mp.ttf');

// Special unicode greek language support
define('LANGUAGE_GREEK', false);

// If you are setting this config to true the conversion of greek characters
// will assume that the input text is windows 1251
define('GREEK_FROM_WINDOWS', false);

// Special unicode cyrillic language support
define('LANGUAGE_CYRILLIC', false);

// If you are setting this config to true the conversion
// will assume that the input text is windows 1251, if
// false it will assume koi8-r
define('CYRILLIC_FROM_WINDOWS', false);

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
// Usage: define('LANGUAGE_CHARSET', $locale_char_set);
//
// where $locale_char_set is a GLOBAL (string) variable
// from the application including JpGraph.
//
define('LANGUAGE_CHARSET', null);

// Japanese TrueType font used with Configs::FF_MINCHO, Configs::FF_PMINCHO, Configs::FF_GOTHIC, Configs::FF_PGOTHIC
// Standard fonts from Infomation-technology Promotion Agency (IPA)
// See http://mix-mplus-ipa.sourceforge.jp/
define('MINCHO_TTF_FONT', 'ipam.ttf');
define('PMINCHO_TTF_FONT', 'ipamp.ttf');
define('GOTHIC_TTF_FONT', 'ipag.ttf');
define('PGOTHIC_TTF_FONT', 'ipagp.ttf');

// Assume that Japanese text have been entered in EUC-JP encoding.
// If this define is true then conversion from EUC-JP to UTF8 is done
// automatically in the library using the mbstring module in PHP.
define('ASSUME_EUCJP_ENCODING', false);

// Line styles
define('LINESTYLE_SOLID', 1);
define('LINESTYLE_DOTTED', 2);
define('LINESTYLE_DASHED', 3);
define('LINESTYLE_LONGDASH', 4);

// Styles for gradient color fill
define('GRAD_VER', 1);
define('GRAD_VERT', 1);
define('GRAD_HOR', 2);
define('GRAD_MIDHOR', 3);
define('GRAD_MIDVER', 4);
define('GRAD_CENTER', 5);
define('GRAD_WIDE_MIDVER', 6);
define('GRAD_WIDE_MIDHOR', 7);
define('GRAD_LEFT_REFLECTION', 8);
define('GRAD_RIGHT_REFLECTION', 9);
define('GRAD_RAISED_PANEL', 10);
define('GRAD_DIAGONAL', 11);

// Special file name to indicate that we only want to calc
// the image map in the call to Graph::Stroke() used
// internally from the GetHTMLCSIM() method.

// HTTP GET argument that is used with image map
// to indicate to the script to just generate the image
// and not the full CSIM HTML page.

// Special filename for Graph::Stroke(). If this filename is given
// then the image will NOT be streamed to browser of file. Instead the
// Stroke call will return the handler for the created GD image.

// Special filename for Graph::Stroke(). If this filename is given
// the image will be stroked to a file with a name based on the script name.

// Tick density
define('TICKD_DENSE', 1);
define('TICKD_NORMAL', 2);
define('TICKD_SPARSE', 3);
define('TICKD_VERYSPARSE', 4);

// Side for ticks and labels.
define('SIDE_LEFT', -1);
define('SIDE_RIGHT', 1);
define('SIDE_DOWN', -1);
define('SIDE_BOTTOM', -1);
define('SIDE_UP', 1);
define('SIDE_TOP', 1);

// Legend type stacked vertical or horizontal
define('LEGEND_VERT', 0);
define('LEGEND_HOR', 1);

// Mark types for plot marks
define('MARK_SQUARE', 1);
define('MARK_UTRIANGLE', 2);
define('MARK_DTRIANGLE', 3);
define('MARK_DIAMOND', 4);
define('MARK_CIRCLE', 5);
define('MARK_FILLEDCIRCLE', 6);
define('MARK_CROSS', 7);
define('MARK_STAR', 8);
define('MARK_X', 9);
define('MARK_LEFTTRIANGLE', 10);
define('MARK_RIGHTTRIANGLE', 11);
define('MARK_FLASH', 12);
define('MARK_IMG', 13);
define('MARK_FLAG1', 14);
define('MARK_FLAG2', 15);
define('MARK_FLAG3', 16);
define('MARK_FLAG4', 17);

// Builtin images
define('MARK_IMG_PUSHPIN', 50);
define('MARK_IMG_SPUSHPIN', 50);
define('MARK_IMG_LPUSHPIN', 51);
define('MARK_IMG_DIAMOND', 52);
define('MARK_IMG_SQUARE', 53);
define('MARK_IMG_STAR', 54);
define('MARK_IMG_BALL', 55);
define('MARK_IMG_SBALL', 55);
define('MARK_IMG_MBALL', 56);
define('MARK_IMG_LBALL', 57);
define('MARK_IMG_BEVEL', 58);

// Inline defines
define('INLINE_YES', 1);
define('INLINE_NO', 0);

// Format for background images
define('BGIMG_FILLPLOT', 1);
define('BGIMG_FILLFRAME', 2);
define('BGIMG_COPY', 3);
define('BGIMG_CENTER', 4);
define('BGIMG_FREE', 5);

// Depth of objects
define('DEPTH_BACK', 0);
define('DEPTH_FRONT', 1);

// Direction
define('VERTICAL', 1);
define('HORIZONTAL', 0);

// Style for title backgrounds
define('TITLEBKG_STYLE1', 1);
define('TITLEBKG_STYLE2', 2);
define('TITLEBKG_STYLE3', 3);
define('TITLEBKG_FRAME_NONE', 0);
define('TITLEBKG_FRAME_FULL', 1);
define('TITLEBKG_FRAME_BOTTOM', 2);
define('TITLEBKG_FRAME_BEVEL', 3);
define('TITLEBKG_FILLSTYLE_HSTRIPED', 1);
define('TITLEBKG_FILLSTYLE_VSTRIPED', 2);
define('TITLEBKG_FILLSTYLE_SOLID', 3);

// Styles for axis labels background
define('LABELBKG_NONE', 0);
define('LABELBKG_XAXIS', 1);
define('LABELBKG_YAXIS', 2);
define('LABELBKG_XAXISFULL', 3);
define('LABELBKG_YAXISFULL', 4);
define('LABELBKG_XYFULL', 5);
define('LABELBKG_XY', 6);

// Style for background gradient fills
define('BGRAD_FRAME', 1);
define('BGRAD_MARGIN', 2);
define('BGRAD_PLOT', 3);

// Defines for 3D skew directions
define('SKEW3D_UP', 0);
define('SKEW3D_DOWN', 1);
define('SKEW3D_LEFT', 2);
define('SKEW3D_RIGHT', 3);

// For internal use only
