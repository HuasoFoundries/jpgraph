<?php

/**
 * JPGraph - Community Edition
 */

use Kint\Kint;
use Tests\BaseTestCase;

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
