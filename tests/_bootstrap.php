<?php

/**
 * JPGraph - Community Edition
 */

\ini_set('display_errors', 1);

\ini_set('display_startup_errors', 1);
define('UNIT_TEST_FOLDER', sprintf('%s/Unit', __DIR__));
define('PROJECT_ROOT', dirname(__DIR__));
//define('CACHE_DIR', __DIR__ . '/_output/');
//define('USE_CACHE', true);
require_once sprintf('%s/vendor/autoload.php', PROJECT_ROOT);
