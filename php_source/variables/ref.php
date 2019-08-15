<?php
$a = "string";
$b = &$a;
echo $a;
echo $b;

$b = "hello!";
echo $a;
echo $b;

unset($b);
echo $b;
echo $a;