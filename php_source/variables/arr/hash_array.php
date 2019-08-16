<?php
$memory_start = memory_get_usage();

$test = [];

for ($i=200000; $i>=0; $i--) {
    $test[$i] = 1;
}

echo memory_get_usage() - $memory_start, " bytes\n";