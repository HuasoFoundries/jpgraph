<?php

/**
 * JPGraph - Community Edition
 */

use Kint\Kint;
use Tests\BaseTestCase;

if (!\function_exists('tap')) {
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    function tap($value, ?callable $callback = null)
    {
        if (null !== $callback) {
            $callback($value);
        }

        return $value;
    }
}
/*
 * Unless there's a dump function declared already, declare
 * one so we can use it safely elsewhere. Mostly used while developing
 */
if (!\function_exists('dump')) {
    // I'm sure this can be improved... just not today
    if (\class_exists(Kint::class)) {
        function dump(...$vars)
        {
            Kint::$enabled_mode = Kint::MODE_CLI;
            $return = Kint::$return;
            Kint::$return = true;
            $fp = \fopen('php://stderr', 'ab');
            \fwrite($fp, Kint::dump(...$vars));
            \fclose($fp);
            $return = Kint::$return;
            Kint::$return = $return;
        }

        Kint::$aliases[] = 'dump';
    } else {
        function dump(...$vars)
        {
        }
    }
}
function examples_path(string $path = ''): string
{
    return \sprintf('%s/Examples/%s', \dirname(BaseTestCase::TEST_FOLDER), ($path ? \DIRECTORY_SEPARATOR . $path : $path));
}

if (!\function_exists('getExampleSubfolderFolderFromTestClassName')) {
    function getExampleSubfolderFolderFromTestClassName(string $testClass, bool $absolute = true): string
    {
        return 'examples_' . \str_replace('test', '', \mb_strtolower($testClass));
    }
}

if (!\function_exists('getTestableExampleFiles')) {
    function getTestableExampleFiles(string $testClass = 'GeneralTest', array $skippedFixtures = []): array
    {
        $exampleRoot = getExampleSubfolderFolderFromTestClassName($testClass);

        if (!\is_dir(examples_path($exampleRoot))) {
            BaseTestCase::line(\sprintf('Folder <warn>%s</warn> for testClass <warn>%s</warn> does not exist', $exampleRoot, $testClass));

            return [];
        }
        $d = \dir(examples_path($exampleRoot));

        while ($entry = $d->Read()) {
            if (!\array_key_exists($entry, $skippedFixtures)
                && \is_file(examples_path(\implode('/', [$exampleRoot, $entry])))
                && \mb_strpos($entry, '.php') !== false
                && \mb_strpos($entry, 'ex') !== false
                && \mb_strpos($entry, 'no_test') === false
                && \mb_strpos($entry, 'no_dim') === false
            ) {
                $fileArray[] = $entry;
            }
        }
        $d->Close();

        return tap($fileArray, fn (&$arr) => \sort($arr));
    }
}

/*
 * Dump to stderr and exit
 */
if (!\function_exists('dd')) {
    function dd(...$vars): void
    {
        dump(...$vars);

        exit();
    }

    if (\class_exists(Kint::class)) {
        Kint::$aliases[] = 'dd';
    }
}
