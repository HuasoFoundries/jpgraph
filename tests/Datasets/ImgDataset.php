<?php



$testClass = str_replace('Dataset.php', 'Test', basename(__FILE__));

dataset($testClass, tap(getMergedFixturesArray($testClass), fn ($totalData) => dump(sprintf('Dataset %s created with %d fixtures', $testClass, count($totalData)))));
