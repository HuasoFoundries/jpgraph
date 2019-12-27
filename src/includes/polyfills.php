<?php

/**
 * JPGraph v4.0.0
 */

if (!class_exists('\Kint')) {
    /**
     * Class that mocks Kint
     * (will use this when dev dependencies are not installed).
     */
    class Kint
    {
        public static $enabled_mode = true;

        public static function dump() {}
    }
    \Kint\Renderer\RichRenderer::$folder = false;
}

if (!class_exists('\PhpConsole\Handler')) {
    /**
     * Class that mocks PHP-Console debug feature.
     */
    class PC
    {
        public static function debug() {}
    }
}
if (property_exists('\Kint', 'aliases')) {
    function ddd(...$vars)
    {
        Kint::dump(...$vars);
        exit;
    }

    function kdump(...$vars)
    {
        ob_start();

        d(...$vars);

        $kintdump = (ob_get_clean());

        //dump($kintdump);
        fwrite(STDERR, $kintdump);

    }

    \Kint::$aliases[] = 'dd';
    \Kint::$aliases[] = 'kdump';
}
if (property_exists('\Kint', 'enabled_mode')) {
    \Kint::$enabled_mode = DEBUGMODE;
    \Kint::$enabled_mode = Kint::$mode_default_cli;
} elseif (method_exists('\Kint', 'enabled')) {
    \Kint::enabled(DEBUGMODE);
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
if (!function_exists('is_countable')) {
    function is_countable($c)
    {
        return is_array($c) || $c instanceof Countable;
    }
}

/**
 * Returns the item count of the variable, or zero if it's non countable.
 *
 * @param mixed $var The variable whose items we want to count
 */
function safe_count($var)
{
    if (is_countable($var)) {
        return count($var);
    }

    return 0;
}
