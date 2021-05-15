<?php

namespace Tests;

use Codeception\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use \Codeception\Util\Debug;
use Exception;

class TestCase    extends \Codeception\Test\Unit
{
    public static $genericFixtures = [];
    public static $persistYaml = false;
    public static $files       = null;
    public static $exampleRoot = null;
    public static $ranTests    = [];
    public static $fixTures    = [];
    public function fixTures($method)
    {
        $arrClassName       =  (explode('\\', static::class));
        $keyname = explode('::', $method)[1];
        //$keyname = str_replace(sprintf('%s::', end($arrClassName)), '', $method);

        if (!array_key_exists($keyname, static::$fixTures)) {
            return [];
        }
        return static::$fixTures[$keyname];
    }
    protected function setUp(): void
    {

        //$this->_setUp();
    }
    public function traverseFixtureGroup($fixTures)
    {
        self::$genericFixtures =
            array_reduce($fixTures, function ($carry, $fixTure) {

                $carry = is_array($fixTure) ? $this->_fixtureCheck($fixTure, $carry) : $this->_fileCheck($fixTure, $carry);
                return $carry;
            }, self::$genericFixtures);
    }

    public static function getFiles($class = '')
    {
        $arr       = explode('\\', static::class);
        $className = array_pop($arr);

        $folder = self::getRoot($className);

        if (!is_readable($folder)) {
            throw new Exception("PANIC: Apache/PHP does not have enough permission to read the scripts in directory: {$folder}");
        }
        if (!is_dir($folder)) {
            throw new Exception("Provided path is not a foldder: {$folder}");
        }
        $d = @dir($folder);
        $fileArray = [];
        while ($entry = $d->Read()) {
            if (
                is_file($folder . $entry) &&
                strstr($entry, '.php') &&
                strstr($entry, 'ex')
                && !strstr($entry, 'no_test')
                && !strstr($entry, 'no_dim')
            ) {
                $fileArray[] = $entry;
            }
        }
        $d->Close();
        sort($fileArray);

        return $fileArray;
    }

    public static function setUpBeforeClass(): void
    {
        $arr       = explode('\\', static::class);
        $className = array_pop($arr);

        $knownFixtures = [];
        static::$files   = static::getFiles(strtolower($className));
        try {
            static::$fixTures = Yaml::parseFile(sprintf('%s/_support/%s.yml', __DIR__, $className));
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
        if (is_array(static::$fixTures)) {
            $knownFixtures = static::getShallowFixtureArray(static::$fixTures);
        } else {
            static::$fixTures = ['testFileIterator' => static::$files];
        }
        static::$files = array_filter(static::$files, function ($filename) use ($knownFixtures) {
            return !array_key_exists($filename, $knownFixtures) ||
                (array_key_exists('testFileIterator', static::$fixTures) &&
                    array_key_exists($filename, static::$fixTures['testFileIterator']));
        });
        /* dump([
            $className => ' has ' . count(static::$files) . ' ungrouped files.',
            'knownFixtures are:' => $knownFixtures
        ]);*/
    }

    public static function tearDownAfterClass(): void
    {
        $arr       = explode('\\', static::class);
        $className = array_pop($arr);
        if (count(static::$genericFixtures) > 0) {

            $yaml = Yaml::dump(static::$genericFixtures);
            if (static::$persistYaml) {

                file_put_contents(sprintf('%s/_support/%s.yml', __DIR__, $className), $yaml);
            }
            fwrite(STDOUT, $className . "\n");
        }
    }

    public static function getRoot($class)
    {
        if (!static::$exampleRoot) {
            static::$exampleRoot = PROJECT_ROOT . '/Examples/examples_' . str_replace('test', '', strtolower($class)) . '/';
        }
        return static::$exampleRoot;
    }

    /**
     * 
     * @param array $fixTureArray 
     * @return array 
     */
    public static function getShallowFixtureArray(array $fixTureArray): array
    {
        return array_reduce(array_keys($fixTureArray), function ($fixTures, $testName) use ($fixTureArray) {
            $filenames = $fixTureArray[$testName];

            $fixTures = array_reduce($filenames, function ($carry, $fixture) use ($testName) {

                if (is_string($fixture)) {
                    $carry[$fixture] = $testName;
                } elseif (is_array($fixture) && array_key_exists('filename', $fixture)) {
                    // ['filename'=><FILE_NAME>,'width'=>x, etc etc]
                    $carry[$fixture['filename']] = $testName;
                } else {
                    dump([$testName . ' fixture should be a string or have a "filename" key ' => $fixture]);
                }
                return $carry;
            }, $fixTures);
            return $fixTures;
        }, []);
    }

    /**
     * Check graph size against declared size. If it doesn't match, rename it.
     *
     * @param string  $exampleRoot  The example root folder
     * @param <type>  $filename     The example filename
     * @param <type>  $__width      The declared width
     * @param <type>  $__height     The declared height
     * @param <type>  $size         The actual size
     *
     * @return boolean  true if file was renamed. False otherwise
     */
    public static function renameIfDimensionsDontMatch($exampleRoot, $filename, $__width, $__height, $size)
    {
        if ($__width != $size[0] || $__height != $size[1]) {
            rename($exampleRoot . $filename, $exampleRoot . 'no_dim_' . $filename);
            return true;
        }
        return false;
    }

    public static function camelCase($inputText)
    {
        $tofind = 'ÀÁÂÄÅàáâäÒÓÔÖòóôöÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ';
        $replac = 'AAAAAaaaaOOOOooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn';

        $campo_sanitizado = utf8_encode(strtr(utf8_decode($inputText), utf8_decode($tofind), $replac));

        $inputText = strtolower(str_replace('%', '_', $campo_sanitizado));
        $inputText = preg_replace('/[^(\x20-\x7F)]*/', '', $inputText);
        $inputText = explode(',', $inputText)[0];
        $inputText = preg_replace_callback('/[^a-zA-Z0-9]+([a-zA-Z0-9]+)/', function ($coincidencias) {
            $fixed           = ucfirst(trim(strtolower($coincidencias[1])));
            $coincidencias[] = $fixed;
            return $fixed;
        }, strtolower(trim($inputText)));

        return $inputText;
    }

    protected function _normalizeTestGroup($filename, &$ownFixtures = [], $example_title = 'file_iterator', $debug = false, $attributes = [])
    {
        $filename_meaningful = explode('ex', $filename)[0];

        if ($example_title === 'file_iterator') {
            $example_title = self::camelCase(sprintf('%s_%s', $filename_meaningful, $example_title));
        }
        $camelCased    = self::camelCase($example_title);
        $test_title    = $camelCased;
        $withoutSuffix = preg_match('/(\w(\s|\w)+\w)\s*(?:(ex|v))?\s*([\.\d]+)$/iU', $test_title, $matches);
        if ($matches) {

            $test_title = self::camelCase($matches[1]);
        }

        $methodName = trim(sprintf('test%s', ucfirst($test_title)));
        $matches    = null;

        if ($debug) {
            Debug::debug([
                'withoutSuffix' => $withoutSuffix,
                'example_title' => $example_title === 'file_iterator' ? 'No Title' : $example_title,
                'camelCased'    => $camelCased,
                'filename'      => $filename,
            ]);
        }
        if (!array_key_exists($methodName, $ownFixtures)) {
            $ownFixtures[$methodName] = [];
        }
        $dims = [];
        if (array_key_exists('mime', $attributes)) {
            $dims = ['width' => $attributes[0], 'height' => $attributes[1]];
        }
        $ownFixtures[$methodName][$filename] = array_merge($dims, [
            'title' => $example_title, 'filename' => $filename, 'example_root' => str_replace(PROJECT_ROOT, '.', static::$exampleRoot)
        ]);
        return $ownFixtures;
    }

    /**
     * Given a filename (whose full path is based on test name)
     * render the container graph and check if the image matches the 
     * expeted dimensions.
     * @param string $filename 
     * @param array $ownFixtures 
     * @param bool $debug 
     * @return array 
     */
    protected function _fileCheck(string $filename, array &$ownFixtures = [], bool $debug = false)
    {
        if (is_array($filename)) {
            if (array_key_exists('width', $filename)) {
                $__width = $filename['width'];
            }
            if (array_key_exists('height', $filename)) {
                $__height = $filename['height'];
            }
            $filename = $filename['filename'];
        }
        $example_title = 'file_iterator';
        $subtitle_text = '';
        ob_start();

        include static::$exampleRoot . $filename;

        $img  = (ob_get_clean());
        $size = getimagesizefromstring($img);

        $size['filename'] = $filename;
        if ($example_title === 'file_iterator' && $subtitle_text) {
            $example_title = $subtitle_text;
        }

        if (isset($__width) && isset($__height)) {

            self::renameIfDimensionsDontMatch(static::$exampleRoot, $filename, $__width, $__height, $size);
            $this->assertEquals($__width, $size[0], 'width should match the one declared for ' . $filename);
            $this->assertEquals($__height, $size[1], 'height should match the one declared for ' . $filename);
        } else {
            Debug::debug(
                'testing ' . $filename .
                    ' for image/jpeg headers '
            );
            //$this->assertEquals('image/jpeg', $size['mime'], 'image should have mime image/jpeg for ' . $filename);
        }
        return $this->_normalizeTestGroup($filename, $ownFixtures, $example_title, $debug, $size);
    }

    /**
     * Given a filename (whose full path is based on test name)
     * render the container graph and check if the image matches the 
     * expeted dimensions.
     * @param string $filename 
     * @param array $ownFixtures 
     * @param bool $debug 
     * @return array 
     */
    protected function _fixtureCheck(array $fixTure, array &$ownFixtures = [], bool $debug = false)
    {

        if (array_key_exists('width', $fixTure)) {
            $__width = $fixTure['width'];
        }
        if (array_key_exists('height', $fixTure)) {
            $__height = $fixTure['height'];
        }
        $filename = $fixTure['filename'];

        $example_title = 'file_iterator';
        $subtitle_text = '';
        ob_start();

        include static::$exampleRoot . $filename;

        $img  = (ob_get_clean());
        $size = getimagesizefromstring($img);

        $size['filename'] = $filename;
        if ($example_title === 'file_iterator' && $subtitle_text) {
            $example_title = $subtitle_text;
        }

        if (isset($__width) && isset($__height)) {

            self::renameIfDimensionsDontMatch(static::$exampleRoot, $filename, $__width, $__height, $size);
            $this->assertEquals($__width, $size[0], 'width should match the one declared for ' . $filename);
            $this->assertEquals($__height, $size[1], 'height should match the one declared for ' . $filename);
        }
        //  tap(
        return $this->_normalizeTestGroup($filename, $ownFixtures, $example_title, $debug, $size);
        //, fn ($normalized) => dump($normalized));
    }
};