<?php

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
define('UNIT_TEST_FOLDER', (dirname(__DIR__)));
//define('CACHE_DIR', __DIR__ . '/_output/');
//define('USE_CACHE', true);

require_once sprintf('%s/vendor/autoload.php', UNIT_TEST_FOLDER);
