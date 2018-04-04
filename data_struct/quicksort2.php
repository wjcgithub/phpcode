<?php
function quickSort($arr)
{
	$count = count($arr);
	if ($count<=1) {
		return $arr;
	}

	//选择一个认为的最大值
	$tmpMiddleVal = $arr[0];
	$minArr = [];
	$maxArr = [];
	for ($i=1; $i < $count; $i++) { 
		if ($tmpMiddleVal > $arr[$i]) {
			$maxArr[] = $arr[$i];
		} else {
			$minArr[] = $arr[$i];
		}
	}

	$minArr = quickSort($minArr);
	$maxArr = quickSort($maxArr);

	return array_merge($maxArr,[$tmpMiddleVal], $minArr);
}


$arr = [2,56,7,89,90,7,54,23,2,4,5,6,7,8,5,4,3,3];
$newArr = quickSort($arr);
print_r($newArr);