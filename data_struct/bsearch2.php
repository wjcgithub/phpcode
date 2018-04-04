<?php
function bSearch($arr, $val)
{
	$count = count($arr);
	if ($count<=0) {
		return -1;
	}

	$left = 0;
	$right = $count;
	while ($left < $right) {
		$middle = floor(($left + $right)/2);
		if ($arr[$middle] > $val) {
			$right = $middle;
		} else if ($arr[$middle] < $val){
			$left = $middle+1;
		} else {
			return $middle;
		}
	}

	return -1;
}

$arr = [1,2,3,5,7,9];
for ($i=0; $i < 20; $i++) {
	echo "search ".$i.", position:".bSearch($arr, $i)."\r\n";
}