<?php

function binarySearch($arr, $search) {

    $count = count($arr);

    if ($count <=0 ) {
        return -1;
    }

    $left = 0;
    $right = $count;

    while ($left < $right) {
        $middle = floor(($right+$left) / 2);
        if ($search > $arr[$middle]) {
            $left = $middle+1;
        }else if ($search < $arr[$middle]){
            $right = $middle;
        }else{
            return $middle;
        }
    }

    return -1;
}


$arr = [1,2,3,4,5,6,7,8,9,10];
print_r(binarySearch($arr, 6));
print_r(binarySearch($arr, 5));
print_r(binarySearch($arr, 9));
print_r(binarySearch($arr, 10));