<?php

/**
 * JPGraph v4.0.0
 */

// Deafult locale for error messages.
// This defaults to English = 'en'
defined('DEFAULT_ERR_LOCALE') || define('DEFAULT_ERR_LOCALE', 'en');

// Locales. ONLY KEPT FOR BACKWARDS COMPATIBILITY
// You should use the proper locale strings directly
// from now on.
defined('LOCALE_EN') || define('LOCALE_EN', 'en_UK');
defined('LOCALE_SV') || define('LOCALE_SV', 'sv_SE');

// Determine if the error handler should be image based or purely
// text based. Image based makes it easier since the script will
// always return an image even in case of errors.
defined('USE_IMAGE_ERROR_HANDLER') || define('USE_IMAGE_ERROR_HANDLER', true);

// Should the library examine the global php_errmsg string and convert
// any error in it to a graphical representation. This is handy for the
// occasions when, for example, header files cannot be found and this results
// in the graph not being created and just a 'red-cross' image would be seen.
// This should be turned off for a production site.
define('CATCH_PHPERRMSG', true);

// Determine if the library should also setup the default PHP
// error handler to generate a graphic error mesage. This is useful
// during development to be able to see the error message as an image
// instead as a 'red-cross' in a page where an image is expected.
define('INSTALL_PHP_ERR_HANDLER', false);

// Should usage of deprecated functions and parameters give a fatal error?
// (Useful to check if code is future proof.)
define('ERR_DEPRECATED', true);

// Default theme class name
defined('DEFAULT_THEME_CLASS') || define('DEFAULT_THEME_CLASS', 'UniversalTheme');

define('SUPERSAMPLING', true);
define('self::SUPERSAMPLING_SCALE', 1);

// Default font family
define('FF_DEFAULT', Configs::FF_DV_SANSSERIF);

// The DEFAULT_GFORMAT sets the default graphic encoding format, i.e.
// PNG, JPG or GIF depending on what is installed on the target system
// in that order.
if (!defined('DEFAULT_GFORMAT')) {
    define('DEFAULT_GFORMAT', 'auto');
}

define('_DEFAULT_LPM_SIZE', 8); // Default Legend Plot Mark size
// For internal use only
define('_JPG_DEBUG', false);
define('_FORCE_IMGTOFILE', false);
define('_FORCE_IMGDIR', '/tmp/jpgimg/');

// Version info
define('JPG_VERSION', '3.5.0b1');

// Minimum required PHP version
define('MIN_PHPVERSION', '7.0.0');

// Special file name to indicate that we only want to calc
// the image map in the call to Graph::Stroke() used
// internally from the GetHTMLCSIM() method.
define('_CSIM_SPECIALFILE', '_csim_special_');

// HTTP GET argument that is used with image map
// to indicate to the script to just generate the image
// and not the full CSIM HTML page.
define('_CSIM_DISPLAY', '_jpg_csimd');

// Special filename for Graph::Stroke(). If this filename is given
// then the image will NOT be streamed to browser of file. Instead the
// Stroke call will return the handler for the created GD image.
define('_IMG_HANDLER', '__handle');

// Special filename for Graph::Stroke(). If this filename is given
// the image will be stroked to a file with a name based on the script name.
define('_IMG_AUTO', 'auto');

define('_FIRST_FONT', 10);
define('_LAST_FONT', 99);
//
// Automatic settings of path for cache and font directory
// if they have not been previously specified
//
if (strstr(PHP_OS, 'WIN')) {
    define('SYSTEMROOT', getenv('SystemRoot'));
}
