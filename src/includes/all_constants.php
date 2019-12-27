






















































































    define('CACHE_DIR', getenv('JPGRAPH_CACHE_DIR'));
    define('DEFAULT_GFORMAT', 'auto');
    define('MBTTF_DIR', getenv('JPGRAPH_MBTTF_DIR'));
    define('SYSTEMROOT', getenv('SystemRoot'));
    define('TTF_DIR', getenv('JPGRAPH_TTF_DIR'));
 *
 *
 *
 *
 *
 *
 *   Configs::CACHE_DIR $SERVER_TEMP/jpgraph_cache/
 *   Configs::CACHE_DIR /tmp/jpgraph_cache/
 *   MBTTF_DIR $SERVER_SYSTEMROOT/fonts/
 *   MBTTF_DIR /usr/share/fonts/truetype/
 *   TTF_DIR   $SERVER_SYSTEMROOT/fonts/
 *   TTF_DIR   /usr/share/fonts/truetype/
 * // and the 'http' version must be the same directory but as
 * // directory from where the image script is executed and store all files
 * // If a relative path is specified it is taken to be relative from where
 * // Note: The default setting is to create a subdirectory in the
 * // preferences.
 * // seen by the HTTP server relative to the 'htdocs' ddirectory.
 * // The directory must be the filesysystem name as seen by PHP
 * // the image script is executed.
 * // there. As ususal this directory must be writeable by the PHP process.
 * // using the cache.
 * be generated in the cache directory.
 * Cache directory specification for use with CSIM graphs that are
 * Configs::CACHE_DIR:
 * cached image files. This directory will not be used if the USE_CACHE
 * define (further down) is false. If you enable the cache please note that
 * Define these constants explicitly or read them from environment vars
 * Defines for font setup
 * Directories for cache and font directory.
 * Directory where TTF fonts can be found. Must end with '/'
 * false will still create the image in the cache directory
 * files will be generated in the cache directory.
 * just not use it. By setting USE_CACHE=false no files will even
 * Must end with '/'
 * NOTE THAT CACHE FUNCTIONALITY IS TURNED OFF BY  DEFAULT ENABLE BY SETTING USE_CACHE TO TRUE)
 * Should the cache be used at all? By setting this to false no
 * The default values used if these defines are left commented out are:
 * The difference from READ_CACHE being that setting READ_CACHE to
 * The following constants should rarely have to be changed !
 * The full absolute name of the directory to be used to store the
 * this directory MUST be readable and writable for the process running PHP.
 * TTF_DIR:
 * UNIX:
 * Various JpGraph Settings. Adjust accordingly to your
 * WINDOWS:
 */
 */
 */
 */
 */
 */
/*
/*
/*
/*
/*
/**
//
//
//
//
//
//
//
//
// (Set to '' will give the default group for the 'PHP-user')
// (Set to '' will give the default persmissions for the 'PHP-user')
// (The supported format depends on what your PHP installation supports)
// (Useful to check if code is future proof.)
// A huge lot of font constants
// A typical such string would be 'UTF-8' or 'utf-8'.
// Actual name of the TTF file used together with Configs::FF_CHINESE aka Configs::FF_BIG5
// always return an image even in case of errors.
// and not the full CSIM HTML page.
// and not the full CSIM HTML page.
// and resulting in just erraneous conversions
// any error in it to a graphical representation. This is handy for the
// Arrow direction for constrain links
// Arrow size for constrain lines
// Arrow type for constrain type
// Assume that Japanese text have been entered in EUC-JP encoding.
// Automatic settings of path for cache and font directory
// automatically in the library using the mbstring module in PHP.
// Available from http://www.gnome.org/fonts/
// Bar patterns
// Builtin images
// Chinese font
// choose the best available format in the order png,gif,jpeg
// containing the input character encoding string
// Conversion constant
// could be needed for some cyrillic people
// Deafult graphic format set to 'auto' which will automatically
// Deafult locale for error messages.
// Default font family
// Default theme class name
// Define these constants explicitly
// define("FF_SPEEDO",71);  // This font is also known as Bauer (Used for development gauge fascia)
// define('CACHE_DIR','/tmp/jpgraph_cache/');
// define('MBTTF_DIR','/usr/share/fonts/TrueType/');
// define('TTF_DIR','/usr/share/fonts/TrueType/');
// Defines for 3D skew directions
// Dejavu-fonts http://sourceforge.net/projects/dejavu
// Depth of objects
// derivate then no conversion is done.
// Determine if the error handler should be image based or purely
// Determine if the library should also setup the default PHP
// Direction
// disabled the cached will still be updated with the newly generated
// Download fonts from
// during development to be able to see the error message as an image
// either Configs::FF_CHINESE or Configs::FF_BIG5
// Enabling this compensation will in general give text a bit more space to more
// error handler to generate a graphic error mesage. This is useful
// Example: In the free project management
// Extra fonts
// false it will assume koi8-r
// For internal use only
// For internal use only
// for not-cyrillic language based people.
// Format for background images
// from now on.
// from the application including JpGraph.
// GD function thinks.
// Gnome Vera font
// Hebrew fonts
// HTTP GET argument that is used with image map
// HTTP GET argument that is used with image map
// http://www.fontonic.com/fonts.asp?width=d&offset=120
// http://www.fontspace.com/category/famous
// http://www.webfontlist.com
// http://www.webpagepublicity.com/free-fonts.html
// if enabled. Just replace 'windows-1251' with a variable
// if they have not been previously specified
// If this charset is not a 'koi8-r' or 'windows-1251'
// If this define is true then conversion from EUC-JP to UTF8 is done
// If you are setting this config to true the conversion
// If you are setting this config to true the conversion of greek characters
// image. Set also 'USE_CACHE' below.
// in that order.
// in the graph not being created and just a 'red-cross' image would be seen.
// Inline defines
// instead as a 'red-cross' in a page where an image is expected.
// internally from the GetHTMLCSIM() method.
// internally from the GetHTMLCSIM() method.
// Japanese font
// Japanese TrueType font used with Configs::FF_MINCHO, Configs::FF_PMINCHO, Configs::FF_GOTHIC, Configs::FF_PGOTHIC
// Layout of bars
// Legend type stacked vertical or horizontal
// Limits for fonts
// Line styles
// Locales. ONLY KEPT FOR BACKWARDS COMPATIBILITY
// Mark types for plot marks
// Maximum size for Automatic Gantt chart
// Minimum required PHP version
// multi-language environments where a cyrillic conversion
// occasions when, for example, header files cannot be found and this results
// of your application calling jpgraph.
// Or read them from environment variables
// Please note that the Apache user must be a member of the
// PNG, JPG or GIF depending on what is installed on the target system
// regenerate the image. Note that even if reading the cache is
// Scale Header types
// See http://mix-mplus-ipa.sourceforge.jp/
// set by the language environment the user has chosen.
// Set this define to false to bypass the reading of the cache and always
// Should the library examine the global php_errmsg string and convert
// Should usage of deprecated functions and parameters give a fatal error?
// Should we try to find an image in the cache before generating it?
// Side for ticks and labels.
// slightly different visual apparance than not using this compensation.
// software dotproject.net $locale_char_set is dynamically
// Special file name to indicate that we only want to calc
// Special file name to indicate that we only want to calc
// Special filename for Graph::Stroke(). If this filename is given
// Special filename for Graph::Stroke(). If this filename is given
// Special filename for Graph::Stroke(). If this filename is given
// Special filename for Graph::Stroke(). If this filename is given
// Special unicode cyrillic language support
// Special unicode greek language support
// specified group since otherwise it is impossible for Apache
// Standard fonts from Infomation-technology Promotion Agency (IPA)
// Stroke call will return the handler for the created GD image.
// Stroke call will return the handler for the created GD image.
// Style for background gradient fills
// Style for day header
// Style for hour header
// Style for minute header
// Style for title backgrounds
// Styles for axis labels background
// Styles for gradient color fill
// Styles for month header
// Styles for week header
// text based. Image based makes it easier since the script will
// text using TTF fonts is buggy. By setting this define to true the library
// The builtin GD function imagettfbbox() fuction which calculates the bounding box for
// The comparison is case-insensitive.
// The DEFAULT_GFORMAT sets the default graphic encoding format, i.e.
// The following constant is used to auto-detect
// the image map in the call to Graph::Stroke() used
// the image map in the call to Graph::Stroke() used
// the image will be stroked to a file with a name based on the script name.
// the image will be stroked to a file with a name based on the script name.
// then the image will NOT be streamed to browser of file. Instead the
// then the image will NOT be streamed to browser of file. Instead the
// This constant can be very important in multi-user
// This defaults to English = 'en'
// This is the TTF file being used when the font family is specified as
// This should be turned off for a production site.
// Tick density
// to indicate to the script to just generate the image
// to indicate to the script to just generate the image
// to set the specified group.
// truly reflect the actual bounding box which is a bit larger than what the
// TTF Font families
// TTF Font styles
// Types of constrain links
// Usage: define('LANGUAGE_CHARSET', $locale_char_set);
// uses its own compensation for this bug. However this will give a
// Version info
// What group should the cached file belong to
// What permissions should the cached file have
// where $locale_char_set is a GLOBAL (string) variable
// whether cyrillic conversion is really necessary
// Width of tab titles
// will assume that the input text is windows 1251
// will assume that the input text is windows 1251, if
// You should use the proper locale strings directly
//Definitions for internal font
<?php
define('_CSIM_DISPLAY', '_jpg_csimd');
define('_CSIM_SPECIALFILE', '_csim_special_');
define('_DEFAULT_LPM_SIZE', 8); // Default Legend Plot Mark size
define('_FIRST_FONT', 10);
define('_FORCE_IMGDIR', '/tmp/jpgimg/');
define('_FORCE_IMGTOFILE', false);
define('_IMG_AUTO', 'auto');
define('_IMG_HANDLER', '__handle');
define('_JPG_DEBUG', false);
define('_LAST_FONT', 99);
define('ARROW_DOWN', 0);
define('ARROW_LEFT', 2);
define('ARROW_RIGHT', 3);
define('ARROW_S1', 0);
define('ARROW_S2', 1);
define('ARROW_S3', 2);
define('ARROW_S4', 3);
define('ARROW_S5', 4);
define('ARROW_UP', 1);
define('ARROWT_OPEN', 1);
define('ARROWT_SOLID', 0);
define('ASSUME_EUCJP_ENCODING', false);
define('BGIMG_CENTER', 4);
define('BGIMG_COPY', 3);
define('BGIMG_FILLFRAME', 2);
define('BGIMG_FILLPLOT', 1);
define('BGIMG_FREE', 5);
define('BGRAD_FRAME', 1);
define('BGRAD_MARGIN', 2);
define('BGRAD_PLOT', 3);
define('CATCH_PHPERRMSG', true);
define('CHINESE_TTF_FONT', 'bkai00mp.ttf');
define('CONSTRAIN_ENDEND', 3);
define('CONSTRAIN_ENDSTART', 2);
define('CONSTRAIN_STARTEND', 1);
define('CONSTRAIN_STARTSTART', 0);
define('CSIMCACHE_DIR', 'csimcache/');
define('CSIMCACHE_HTTP_DIR', 'csimcache/');
define('CYRILLIC_FROM_WINDOWS', false);
define('DAYADJ_1', 0);
define('DAYADJ_7', 1);
define('DAYADJ_WEEK', 1);
define('DAYSTYLE_CUSTOM', 12); // "M"
define('DAYSTYLE_LONG', 1); // "Monday"
define('DAYSTYLE_LONGDAYDATE1', 2); // "Monday 23 Jun"
define('DAYSTYLE_LONGDAYDATE2', 3); // "Monday 23 Jun 2003"
define('DAYSTYLE_ONELETTER', 0); // "M"
define('DAYSTYLE_SHORT', 4); // "Mon"
define('DAYSTYLE_SHORTDATE1', 8); // "23/6"
define('DAYSTYLE_SHORTDATE2', 9); // "23 Jun"
define('DAYSTYLE_SHORTDATE3', 10); // "Mon 23"
define('DAYSTYLE_SHORTDATE4', 11); // "23"
define('DAYSTYLE_SHORTDAYDATE1', 5); // "Mon 23/6"
define('DAYSTYLE_SHORTDAYDATE2', 6); // "Mon 23 Jun"
define('DAYSTYLE_SHORTDAYDATE3', 7); // "Mon 23"
define('DEFAULT_GFORMAT', 'auto');
define('DEPTH_BACK', 0);
define('DEPTH_FRONT', 1);
define('ERR_DEPRECATED', true);
define('FF_AHRON', 46);
define('FF_ARIAL', 15);
define('FF_BIG5', 32);
define('FF_CALCULATOR', 74); // Triad font
define('FF_CHINESE', 31);
define('FF_COMIC', 14);
define('FF_COMPUTER', 73); // The classic computer font
define('FF_COURIER', 10);
define('FF_DAVID', 44);
define('FF_DEFAULT', Configs::FF_DV_SANSSERIF);
define('FF_DIGITAL', 72); // Digital readout font
define('FF_DV_SANSSERIF', 47);
define('FF_DV_SANSSERIFCOND', 51);
define('FF_DV_SANSSERIFMONO', 49);
define('FF_DV_SERIF', 48);
define('FF_DV_SERIFCOND', 50);
define('FF_FONT0', 1);
define('FF_FONT1', 2);
define('FF_FONT2', 4);
define('FF_GEORGIA', 16);
define('FF_GOTHIC', 42);
define('FF_MINCHO', 40);
define('FF_MIRIAM', 45);
define('FF_PGOTHIC', 43);
define('FF_PMINCHO', 41);
define('FF_SIMSUN', 30);
define('FF_TIMES', 12);
define('FF_TREBUCHE', 17);
define('FF_USERFONT', 90);
define('FF_USERFONT1', 90);
define('FF_USERFONT2', 91);
define('FF_USERFONT3', 92);
define('FF_VERA', 18);
define('FF_VERAMONO', 19);
define('FF_VERASERIF', 20);
define('FF_VERDANA', 11);
define('FS_BOLD', 9002);
define('FS_BOLDIT', 9004);
define('FS_BOLDITALIC', 9004);
define('FS_ITALIC', 9003);
define('FS_NORMAL', 9001);
define('GANTT_3DPLANE', Configs::BAND_3DPLANE); // "3D" Plane
define('GANTT_DIAGCROSS', Configs::BAND_DIAGCROSS); // Diagonal crosses
define('GANTT_EVEN', 1);
define('GANTT_FROMTOP', 2);
define('GANTT_HDAY', 1);
define('GANTT_HHOUR', 16);
define('GANTT_HLINE', Configs::BAND_HLINE); // Horizontal lines
define('GANTT_HMIN', 32);
define('GANTT_HMONTH', 4);
define('GANTT_HVCROSS', Configs::BAND_HVCROSS); // Vertical/Hor crosses
define('GANTT_HWEEK', 2);
define('GANTT_HYEAR', 8);
define('GANTT_LDIAG', Configs::BAND_LDIAG); // Left diagonal lines
define('GANTT_RDIAG', Configs::BAND_RDIAG); // Right diagonal lines
define('GANTT_SOLID', Configs::BAND_SOLID); // Solid one color
define('GANTT_VLINE', Configs::BAND_VLINE); // Vertical lines
define('GICON_CALC', 5);
define('GICON_ENDCONS', 2);
define('GICON_FOLDER', 11);
define('GICON_FOLDEROPEN', 10);
define('GICON_LOCK', 7);
define('GICON_MAGNIFIER', 6);
define('GICON_MAIL', 3);
define('GICON_STARTCONS', 4);
define('GICON_STOP', 8);
define('GICON_TEXT', 1);
define('GICON_TEXTIMPORTANT', 12);
define('GICON_WARNINGRED', 0);
define('GICON_WARNINGYELLOW', 9);
define('GOTHIC_TTF_FONT', 'ipag.ttf');
define('GRAD_CENTER', 5);
define('GRAD_DIAGONAL', 11);
define('GRAD_HOR', 2);
define('GRAD_LEFT_REFLECTION', 8);
define('GRAD_MIDHOR', 3);
define('GRAD_MIDVER', 4);
define('GRAD_RAISED_PANEL', 10);
define('GRAD_RIGHT_REFLECTION', 9);
define('GRAD_VER', 1);
define('GRAD_VERT', 1);
define('GRAD_WIDE_MIDHOR', 7);
define('GRAD_WIDE_MIDVER', 6);
define('GREEK_FROM_WINDOWS', false);
define('HORIZONTAL', 0);
define('HOURADJ_1', 0 + 30);
define('HOURADJ_12', 5 + 30);
define('HOURADJ_2', 1 + 30);
define('HOURADJ_3', 2 + 30);
define('HOURADJ_4', 3 + 30);
define('HOURADJ_6', 4 + 30);
define('HOURSTYLE_CUSTOM', 4); // User defined
define('HOURSTYLE_H24', 2); // 13
define('HOURSTYLE_HAMPM', 3); // 1pm
define('HOURSTYLE_HM24', 0); // 13:10
define('HOURSTYLE_HMAMPM', 1); // 1:10pm
define('INLINE_NO', 0);
define('INLINE_YES', 1);
define('INSTALL_PHP_ERR_HANDLER', false);
define('JPG_VERSION', '3.5.0b1');
define('LABELBKG_NONE', 0);
define('LABELBKG_XAXIS', 1);
define('LABELBKG_XAXISFULL', 3);
define('LABELBKG_XY', 6);
define('LABELBKG_XYFULL', 5);
define('LABELBKG_YAXIS', 2);
define('LABELBKG_YAXISFULL', 4);
define('LANGUAGE_CHARSET', null);
define('LANGUAGE_CYRILLIC', false);
define('LANGUAGE_GREEK', false);
define('LEGEND_HOR', 1);
define('LEGEND_VERT', 0);
define('LINESTYLE_DASHED', 3);
define('LINESTYLE_DOTTED', 2);
define('LINESTYLE_LONGDASH', 4);
define('LINESTYLE_SOLID', 1);
define('MARK_CIRCLE', 5);
define('MARK_CROSS', 7);
define('MARK_DIAMOND', 4);
define('MARK_DTRIANGLE', 3);
define('MARK_FILLEDCIRCLE', 6);
define('MARK_FLAG1', 14);
define('MARK_FLAG2', 15);
define('MARK_FLAG3', 16);
define('MARK_FLAG4', 17);
define('MARK_FLASH', 12);
define('MARK_IMG', 13);
define('MARK_IMG_BALL', 55);
define('MARK_IMG_BEVEL', 58);
define('MARK_IMG_DIAMOND', 52);
define('MARK_IMG_LBALL', 57);
define('MARK_IMG_LPUSHPIN', 51);
define('MARK_IMG_MBALL', 56);
define('MARK_IMG_PUSHPIN', 50);
define('MARK_IMG_SBALL', 55);
define('MARK_IMG_SPUSHPIN', 50);
define('MARK_IMG_SQUARE', 53);
define('MARK_IMG_STAR', 54);
define('MARK_LEFTTRIANGLE', 10);
define('MARK_RIGHTTRIANGLE', 11);
define('MARK_SQUARE', 1);
define('MARK_STAR', 8);
define('MARK_UTRIANGLE', 2);
define('MARK_X', 9);
define('MAX_GANTTIMG_SIZE_H', 5000);
define('MAX_GANTTIMG_SIZE_W', 8000);
define('MIN_PHPVERSION', '7.0.0');
define('MINADJ_1', 0 + 20);
define('MINADJ_10', 2 + 20);
define('MINADJ_15', 3 + 20);
define('MINADJ_30', 4 + 20);
define('MINADJ_5', 1 + 20);
define('MINCHO_TTF_FONT', 'ipam.ttf');
define('MINUTESTYLE_CUSTOM', 2); // Custom format
define('MINUTESTYLE_MM', 0); // 15
define('MONTHADJ_1', 0 + 20);
define('MONTHADJ_6', 1 + 20);
define('MONTHSTYLE_FIRSTLETTER', 6);
define('MONTHSTYLE_LONGNAME', 1);
define('MONTHSTYLE_LONGNAMEYEAR2', 2);
define('MONTHSTYLE_LONGNAMEYEAR4', 4);
define('MONTHSTYLE_SHORTNAME', 0);
define('MONTHSTYLE_SHORTNAMEYEAR2', 3);
define('MONTHSTYLE_SHORTNAMEYEAR4', 5);
define('PGOTHIC_TTF_FONT', 'ipagp.ttf');
define('PMINCHO_TTF_FONT', 'ipamp.ttf');
define('SECADJ_1', 0);
define('SECADJ_10', 2);
define('SECADJ_15', 3);
define('SECADJ_30', 4);
define('SECADJ_5', 1);
define('SECPERDAY', 86400);
define('SECPERHOUR', 3600);
define('SECPERMIN', 60);
define('SECPERYEAR', 31536000);
define('SIDE_BOTTOM', -1);
define('SIDE_DOWN', -1);
define('SIDE_LEFT', -1);
define('SIDE_RIGHT', 1);
define('SIDE_TOP', 1);
define('SIDE_UP', 1);
define('SKEW3D_DOWN', 1);
define('SKEW3D_LEFT', 2);
define('SKEW3D_RIGHT', 3);
define('SKEW3D_UP', 0);
define('SUPERSAMPLING', true);
define('SUPERSAMPLING_SCALE', 1);
define('TABTITLE_WIDTHFIT', 0);
define('TABTITLE_WIDTHFULL', -1);
define('TICKD_DENSE', 1);
define('TICKD_NORMAL', 2);
define('TICKD_SPARSE', 3);
define('TICKD_VERYSPARSE', 4);
define('TITLEBKG_FILLSTYLE_HSTRIPED', 1);
define('TITLEBKG_FILLSTYLE_SOLID', 3);
define('TITLEBKG_FILLSTYLE_VSTRIPED', 2);
define('TITLEBKG_FRAME_BEVEL', 3);
define('TITLEBKG_FRAME_BOTTOM', 2);
define('TITLEBKG_FRAME_FULL', 1);
define('TITLEBKG_FRAME_NONE', 0);
define('TITLEBKG_STYLE1', 1);
define('TITLEBKG_STYLE2', 2);
define('TITLEBKG_STYLE3', 3);
define('USE_LIBRARY_IMAGETTFBBOX', true);
define('VERTICAL', 1);
define('WEEKSTYLE_FIRSTDAY', 1);
define('WEEKSTYLE_FIRSTDAY2', 2);
define('WEEKSTYLE_FIRSTDAY2WNBR', 4);
define('WEEKSTYLE_FIRSTDAYWNBR', 3);
define('WEEKSTYLE_WNBR', 0);
define('YEARADJ_1', 0 + 30);
define('YEARADJ_2', 1 + 30);
define('YEARADJ_5', 2 + 30);
defined('CACHE_FILE_GROUP') || define('CACHE_FILE_GROUP', getenv('JPGRAPH_CACHE_FILE_GROUP') || 'www');
defined('CACHE_FILE_MOD') || define('CACHE_FILE_MOD', getenv('JPGRAPH_CACHE_FILE_MOD') || 0664);
defined('DEFAULT_ERR_LOCALE') || define('DEFAULT_ERR_LOCALE', 'en');
defined('DEFAULT_THEME_CLASS') || define('DEFAULT_THEME_CLASS', 'UniversalTheme');
defined('LOCALE_EN') || define('LOCALE_EN', 'en_UK');
defined('LOCALE_SV') || define('LOCALE_SV', 'sv_SE');
defined('READ_CACHE') || define('READ_CACHE', true);
defined('USE_CACHE') || define('USE_CACHE', getenv('JPGRAPH_USE_CACHE') || false);
defined('USE_IMAGE_ERROR_HANDLER') || define('USE_IMAGE_ERROR_HANDLER', true);
if (!defined('DEFAULT_GFORMAT')) {
    if (getenv('JPGRAPH_CACHE_DIR')) {
        if (getenv('JPGRAPH_MBTTF_DIR')) {
            if (getenv('JPGRAPH_TTF_DIR')) {
                if (strstr(PHP_OS, 'WIN')) {
                }
            }
        }
    }
}
