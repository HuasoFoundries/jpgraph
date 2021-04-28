<?php

use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\Yaml\Yaml;
use Tests\BaseTestCase;
use Tests\SizeFixture;

ini_set('display_errors', 'On');

ini_set('display_startup_errors', 'On');



/**
 * Parses the contents of a yaml file (in `tests/_support`) and marshallize it
 * as a fixture array
 * 
 * @param string $testClass the testname/filename/groupname we use to figure out final fixture paths
 * @param array $fixtureArray an array to which the output will be concatenated. By default, []
 * @return array the input $fixtureArray plus the fixtures we figured out from the yaml file
 */
function getFixturesFromYamlDefinition(string $testClass, array $fixtureArray = []): array
{
    $exampleRoot = getExampleSubfolderFolderFromTestClassName($testClass);
    $filePath = sprintf('%s/_support/%s.yml', (__DIR__), $testClass);
    if (!is_file($filePath)) {
        return [];
    }
    try {
        $examplesArray = Yaml::parseFile($filePath);
        foreach ($examplesArray as $exampleName => $exampleData) {
            try {
                $itemsWithImageDimensions = array_filter(array_values($exampleData), function ($fixTure) {
                    return     array_key_exists('width', $fixTure) && array_key_exists('height', $fixTure);
                });

                $exampleDataWithPath = array_map(
                    function ($example) use ($exampleRoot, &$fileList) {
                        $exampleSorted = [
                            'title' => $example['title'] ?? basename($example['filename']),
                            'filename' => $example['filename']
                        ];

                        $example['example_root'] = $exampleRoot;
                        $fileList[$example['filename']] = $exampleSorted['title'];
                        return [$exampleSorted['filename'] => array_merge($exampleSorted, $example)];
                    },
                    $itemsWithImageDimensions
                );
                $fixtureArray = array_merge($fixtureArray, $exampleDataWithPath);
            } catch (Exception $err) {
                dump([$err->getMessage() => $exampleData]);
            }
        }
    } catch (Exception $err) {
        dump([$filePath => $err->getMessage()]);
    }
    return tap($fixtureArray, function (&$arr) {
        sort($arr);
    });
}
/**
 * 
 * @param string $testClass the testname/filename/groupname we use to figure out final fixture paths
 * @return array 
 */
function getMergedFixturesArray(string $testClass): array
{
    $fixtures = getFixturesFromYamlDefinition($testClass);

    $fileArray = getTestableExampleFiles($testClass, $fixtures);
    return tap([
        'testClass' => $fixtures,
        'plainFile' => array_map(
            fn (string $filename) => [
                $filename => [
                    'filename' => $filename,
                    'example_root' => getExampleSubfolderFolderFromTestClassName($testClass)
                ]
            ],
            $fileArray
        )
    ], fn ($datasetPair) => null && dump($datasetPair));
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

uses(Tests\BaseTestCase::class)->in('Unit');
uses(Tests\BaseTestCase::class)->in('Feature');

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



expect()->extend('toMatchImageType', function (SizeFixture $sizeFixture, array  $options = ['copyOnFail' => false]) {
    $filename = $sizeFixture->filename;
    $img  = $sizeFixture->captureImage(SizeFixture::SAVE_CAPTURE_IF_NOT_EXISTS);
    $size = getimagesizefromstring($img);

    $size['filename'] = $filename;
    try {
        return       expect($size['mime'])->toEqual('image/png');
    } catch (ExpectationFailedException $err) {
        dump([$filename => $size]);

        throw $err;
    }
});
expect()->extend('toMatchFixture', function (SizeFixture $sizeFixture, array  $options = ['copyOnFail' => false]) {

    $filename = $sizeFixture->filename;
    $img  = $sizeFixture->captureImage(SizeFixture::SAVE_CAPTURE_IF_NOT_EXISTS);
    $size = getimagesizefromstring($img);
    $size['filename'] = $filename;
    try {
        return expect($size[0])->toEqual($sizeFixture->width)
            ->and($size[1])->toEqual($sizeFixture->height);
    } catch (ExpectationFailedException $err) {
        $size['expected'] = [$sizeFixture->width, $sizeFixture->height];
        dump([$filename => $size]);


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
