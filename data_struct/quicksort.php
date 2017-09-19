<?php
function bSearch($arr)
{
	$count = count($arr);
	print_r($arr);
	if ($count<=1) {
		return $arr;
	}

	$minArr = [];
	$maxArr = [];

	$tmpMiddleVal = $arr[0];
	for ($i=1; $i < $count; $i++) { 
		if ($arr[$i] > $tmpMiddleVal) {
			$maxArr[] = $arr[$i];
		}else{
			$minArr[] = $arr[$i];
		}
	}
	
	sleep(1);
	$minArr = bSearch($minArr);
	$maxArr = bSearch($maxArr);
	return array_merge($minArr,[$tmpMiddleVal],$maxArr);
}


$arr = [2,56,7,89,90,7,54,23,2,4,5,6,7,8,5,4,3,3];
$newArr = bSearch($arr);
print_r($newArr);