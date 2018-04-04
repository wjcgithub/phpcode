<?php
function bSearch($arr,$val)
{
	$count = count($arr);
	if ($count<=0) {
		return -1;
	}

	$start = 0;
	$end = $count;
	while ($start < $end) {
		$middle = floor(($start+$end)/2);
		if ($val > $arr[$middle]) {
			$start = $middle+1;
		}else if($val < $arr[$middle]){
			$end = $middle;
		} else {
			return $middle;
		}
	}

	return -1;
}

$arr = [1,2,3,4,5,6,7,8,9,10];
echo bSearch($arr,8);