<?php
$memory_start = memory_get_usage();

$test = [];

for ($i=0; $i<=200000; $i++) {
    $test[$i] = 1;
}

echo memory_get_usage() - $memory_start, " bytes\n";



$memory_start = memory_get_usage();

$test1 = [];

for ($i=4; $i<=200000; $i++) {
    $test1[$i] = 1;
}

echo memory_get_usage() - $memory_start, " bytes\n";