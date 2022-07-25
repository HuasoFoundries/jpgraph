<?php

/**
 * JPGraph - Community Edition
 */

use Symfony\Component\Yaml\Yaml;

$filePath = \sprintf('%s/_support/%s.yml', \dirname(__DIR__), \str_replace('Datasets.php', 'Test', \basename(__FILE__)));

$examplesArray = Yaml::parseFile($filePath);
//dump($examplesArray);
