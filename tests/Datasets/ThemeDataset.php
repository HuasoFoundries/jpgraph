<?php



$testClass = str_replace('Dataset.php', 'Test', basename(__FILE__));

tap(getMergedFixturesArray($testClass),function ($groups) use ($testClass) {
    dataset($testClass, $groups['testClass']);
    dataset($testClass . 'PlainFile', $groups['plainFile']);
});
