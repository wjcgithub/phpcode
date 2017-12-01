<?php
// $str = "<title>aaaaaa</title>";
// $str = "<title>aaAAAA</title>";
// $str = "<title>aAaaaaAaaAaa</title>";
// $zz = /<title>/(.*?)<\/title>/ixums;
// phpinfo();
error_reporting(E_ALL);
$b='';
if (isset($a)) {
	echo 'a设置了';
} else {
	echo 'a没设置';
}

echo "\r\n";

if (empty($a)) {
	echo 'a为空';
} else {
	echo 'a不为空';
}

echo "\r\n";

if (empty($b)) {
	echo '0000';
} else {
	echo '111';
}

echo "\r\n";


if (empty($arr['item'])) {
	echo '0000';
} else {
	echo '111';
}

echo "\r\n";
