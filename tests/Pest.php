<?php

use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\Yaml\Yaml;
use Tests\SizeFixture;

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
define('UNIT_TEST_FOLDER', sprintf('%s/Unit', __DIR__));
define('PROJECT_ROOT', dirname(__DIR__));
//define('CACHE_DIR', __DIR__ . '/_output/');
//define('USE_CACHE', true);
require_once sprintf('%s/vendor/autoload.php', PROJECT_ROOT);




function getMergedFixturesArray($testClass)
{
    $fileArray = [];
    $filePath = sprintf('%s/_support/%s.yml', (__DIR__), $testClass);
    $exampleRoot = PROJECT_ROOT . '/Examples/examples_' . str_replace('test', '', strtolower($testClass)) . '/';


    $datasetNames = [];
    $totalData = [];
    $fileList = [];
    if (is_file($filePath)) {
        try {
            $examplesArray = Yaml::parseFile($filePath);
            foreach ($examplesArray as $exampleName => $exampleData) {
                try {
                    $arrayValues = array_values($exampleData);
                    $exampleDataWithPath = array_map(function ($example) use ($exampleRoot, &$fileList) {
                        $exampleSorted = ['title' => $example['title'] ?? basename($example['filename']), 'filename' => $example['filename']];

                        $example['example_root'] = str_replace(PROJECT_ROOT, '.', $exampleRoot);
                        $fileList[$example['filename']] = $exampleSorted['title'];
                        return [$exampleSorted['filename'] => array_merge($exampleSorted, $example)];
                    }, $arrayValues);
                    $totalData = array_merge($totalData, $exampleDataWithPath);

                    $datasetNames[] = $exampleName;
                } catch (Exception $err) {
                    dump([$err->getMessage() => $exampleData]);
                }
            }
        } catch (Exception $err) {
            dump([$err->getMessage() => $testClass]);
        }
        sort($totalData);
    }
    if (is_dir($exampleRoot)) {


        $d = @dir($exampleRoot);

        while ($entry = $d->Read()) {
            if (
                !array_key_exists($entry, $fileList) &&
                is_file($exampleRoot . $entry) &&
                strstr($entry, '.php') &&
                strstr($entry, 'ex')
                && !strstr($entry, 'no_test')
                && !strstr($entry, 'no_dim')
            ) {
                $fileArray[] = $entry;
            }
        }
        $d->Close();
    } else {
        dump(['not a folder' => $exampleRoot]);
    }
    sort($fileArray);
    if (count($fileArray) > 0) {
        //dump([$testClass => ($fileArray)]);
    }


    return $totalData;
}
/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(Tests\TestCase::class)->in('Unit');
uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});


expect()->extend('toMatchFixture', function (SizeFixture $sizeFixture, array  $options = ['copyOnFail' => false]) {


    $__width = $sizeFixture->width;

    $__height = $sizeFixture->height;

    $filename = $sizeFixture->filename;

    $example_title = $sizeFixture->title;
    $subtitle_text = '';
    ob_start();

    include $sizeFixture->example_root . $filename;

    $img  = (ob_get_clean());
    $size = getimagesizefromstring($img);

    $size['filename'] = $filename;
    if ($example_title === 'file_iterator' && $subtitle_text) {
        $example_title = $subtitle_text;
    }
    try {

        return expect($size[0])->toEqual($sizeFixture->width)
            ->and($size[1])->toEqual($sizeFixture->height);
    } catch (ExpectationFailedException $err) {
        $size['expected'] = [$__width, $__height];
        dump([$filename => $size]);
        file_put_contents(__DIR__ . '/_support/_generated/' . $filename . '.jpg', $img);
        throw $err;
    }
});
/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}
