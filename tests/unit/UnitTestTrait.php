<?php
namespace Amenadiel\JpGraph\UnitTest;

use Symfony\Component\Yaml\Yaml;
use \Codeception\Util\Debug;

trait UnitTestTrait
{
    public static $exampleRoot;

    public static $genericFixtures;
    public static function getFiles($className)
    {
        $folder = self::getRoot($className);

        $d = @dir($folder);
        $a = [];
        while ($entry = $d->Read()) {
            if (is_file($folder . $entry) &&
                strstr($entry, '.php') &&
                strstr($entry, 'ex')
                && !strstr($entry, 'no_test')
                && !strstr($entry, 'no_dim')) {
                $a[] = $entry;
            }
        }
        $d->Close();
        if (count($a) == 0) {
            die("PANIC: Apache/PHP does not have enough permission to read the scripts in directory: {$folder}");
        }
        sort($a);

        return $a;
    }

    public static function tearDownAfterClass(): void
    {
        Debug::debug('non grouped fixtures:');
        Debug::debug(self::$genericFixtures);
        $yaml = Yaml::dump(self::$genericFixtures);

        file_put_contents(sprintf('%s/../%s.yml', __DIR__, get_class()), $yaml);
        fwrite(STDOUT, get_class() . "\n");
    }

    public static function getRoot($class)
    {
        if (!self::$exampleRoot) {
            self::$exampleRoot = UNIT_TEST_FOLDER . '/Examples/examples_' . $class . '/';
        }
        return self::$exampleRoot;
    }

    public static function getShallowFixtureArray($fixTureArray)
    {
        return array_reduce(array_keys($fixTureArray), function ($fixTures, $testName) use ($fixTureArray) {
            $filenames = $fixTureArray[$testName];
            $fixTures  = array_reduce($filenames, function ($carry, $filename) use ($testName) {
                $carry[$filename] = $testName;
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

        $inputText = str_replace('%', '_', $campo_sanitizado);
        $inputText = preg_replace('/[^(\x20-\x7F)]*/', '', $inputText);
        $inputText = preg_replace_callback('/[^a-zA-Z0-9]+([a-zA-Z0-9]+)/', function ($coincidencias) {
            $fixed           = ucfirst(trim(strtolower($coincidencias[1])));
            $coincidencias[] = $fixed;
            return $fixed;
        }, $inputText);

        return $inputText;
    }

    private function _normalizeTestGroup($filename, &$ownFixtures = [], $example_title = 'file_iterator', $debug = false)
    {
        $camelCased    = self::camelCase($example_title);
        $test_title    = $camelCased;
        $withoutSuffix = preg_match('/(\w(\s|\w)+\w)\s*(?:(ex|v))?\s*([\.\d]+)$/iU', $test_title, $matches);
        if ($matches) {
            $test_title = self::camelCase($matches[1]);
        }

        $methodName = sprintf('test%s', $test_title);
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
        $ownFixtures[$methodName][$filename] = $example_title;
        return $ownFixtures;
    }

    private function _fileCheck($filename, &$ownFixtures = [], $debug = false)
    {
        $example_title = 'file_iterator';
        ob_start();

        include self::$exampleRoot . $filename;

        $img  = (ob_get_clean());
        $size = getimagesizefromstring($img);

        $size['filename'] = $filename;
        self::renameIfDimensionsDontMatch(self::$exampleRoot, $filename, $__width, $__height, $size);
        $this->assertEquals($__width, $size[0], 'width should match the one declared for ' . $filename);
        $this->assertEquals($__height, $size[1], 'height should match the one declared for ' . $filename);
        return $this->_normalizeTestGroup($filename, $ownFixtures, $example_title, $debug);
    }
};
