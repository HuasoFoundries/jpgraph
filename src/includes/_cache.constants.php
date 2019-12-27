<?php

/**
 * JPGraph v4.0.0
 */

defined('USE_CACHE') || define('USE_CACHE', getenv('JPGRAPH_USE_CACHE') || false);

/*
 * Directories for cache and font directory.
 * Define these constants explicitly or read them from environment vars
 *
 * Configs::CACHE_DIR:
 * The full absolute name of the directory to be used to store the
 * cached image files. This directory will not be used if the USE_CACHE
 * define (further down) is false. If you enable the cache please note that
 * this directory MUST be readable and writable for the process running PHP.
 * Must end with '/'
 *
 * TTF_DIR:
 * Directory where TTF fonts can be found. Must end with '/'
 *
 * The default values used if these defines are left commented out are:
 *
 * UNIX:
 *   Configs::CACHE_DIR /tmp/jpgraph_cache/
 *   TTF_DIR   /usr/share/fonts/truetype/
 *   MBTTF_DIR /usr/share/fonts/truetype/
 *
 * WINDOWS:
 *   Configs::CACHE_DIR $SERVER_TEMP/jpgraph_cache/
 *   TTF_DIR   $SERVER_SYSTEMROOT/fonts/
 *   MBTTF_DIR $SERVER_SYSTEMROOT/fonts/
 *
 */

// Define these constants explicitly
// define('CACHE_DIR','/tmp/jpgraph_cache/');
// define('TTF_DIR','/usr/share/fonts/TrueType/');
// define('MBTTF_DIR','/usr/share/fonts/TrueType/');
//
// Or read them from environment variables
if (getenv('JPGRAPH_CACHE_DIR')) {
    define('CACHE_DIR', getenv('JPGRAPH_CACHE_DIR'));
}
if (getenv('JPGRAPH_TTF_DIR')) {
    define('TTF_DIR', getenv('JPGRAPH_TTF_DIR'));
}
if (getenv('JPGRAPH_MBTTF_DIR')) {
    define('MBTTF_DIR', getenv('JPGRAPH_MBTTF_DIR'));
}

/*
 * Cache directory specification for use with CSIM graphs that are
 * // using the cache.
 * // The directory must be the filesysystem name as seen by PHP
 * // and the 'http' version must be the same directory but as
 * // seen by the HTTP server relative to the 'htdocs' ddirectory.
 * // If a relative path is specified it is taken to be relative from where
 * // the image script is executed.
 * // Note: The default setting is to create a subdirectory in the
 * // directory from where the image script is executed and store all files
 * // there. As ususal this directory must be writeable by the PHP process.
 */
define('CSIMCACHE_DIR', 'csimcache/');
define('CSIMCACHE_HTTP_DIR', 'csimcache/');

// Should we try to find an image in the cache before generating it?
// Set this define to false to bypass the reading of the cache and always
// regenerate the image. Note that even if reading the cache is
// disabled the cached will still be updated with the newly generated
// image. Set also 'USE_CACHE' below.
defined('READ_CACHE') || define('READ_CACHE', true);

/*
 * The following constants should rarely have to be changed !
 */
// What group should the cached file belong to
// (Set to '' will give the default group for the 'PHP-user')
// Please note that the Apache user must be a member of the
// specified group since otherwise it is impossible for Apache
// to set the specified group.
defined('CACHE_FILE_GROUP') || define('CACHE_FILE_GROUP', getenv('JPGRAPH_CACHE_FILE_GROUP') || 'www');

// What permissions should the cached file have
// (Set to '' will give the default persmissions for the 'PHP-user')
defined('CACHE_FILE_MOD') || define('CACHE_FILE_MOD', getenv('JPGRAPH_CACHE_FILE_MOD') || 0664);
