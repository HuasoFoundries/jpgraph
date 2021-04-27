<?php

/**
 * JPGraph v4.1.0-beta.01
 */
if (!defined('STDIN')) {
    define('STDIN', fopen('php://stdin', 'rb'));
}

if (!defined('STDOUT')) {
    define('STDOUT', fopen('php://stdout', 'wb'));
}

if (!defined('STDERR')) {
    define('STDERR', fopen('php://stderr', 'wb'));
}

if (!class_exists('\Kint')) {
    /**
     * Class that mocks Kint
     * (will use this when dev dependencies are not installed).
     */
    class Kint
    {
        public static $enabled_mode     = true;
        public static $aliases          = [];
        public static $mode_default_cli = false;
        public static function dump()
        {
        }
    }
}
if (class_exists('\Kint\Renderer\RichRenderer')) {
    \Kint\Renderer\RichRenderer::$folder = false;
}
if (method_exists('\Kint', 'enabled')) {
    \Kint::enabled(DEBUGMODE);
} elseif (property_exists('\Kint', 'enabled_mode')) {
    \Kint::$enabled_mode = Kint::$mode_default_cli;
}

if (!class_exists('\PhpConsole\Handler')) {
    /**
     * Class that mocks PHP-Console debug feature.
     */
    class PC
    {
        public static function debug()
        {
        }
    }
}

if (!function_exists('kdump')) {
    function kdump(...$vars)
    {
        ob_start();

        d(...$vars);

        $kintdump = (ob_get_clean());

        //dump($kintdump);
        fwrite(STDERR, $kintdump);
    }



    \Kint::$aliases[] = 'kdump';
}
if (
    getenv('JPGRAPH_USE_PHPCONSOLE') &&
    isset($_SERVER['HTTP_USER_AGENT']) &&
    strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false
) {
    $handler = \PhpConsole\Handler::getInstance();
    \PhpConsole\Helper::register();
    $handler->start();
    \PC::debug('Started');
}
