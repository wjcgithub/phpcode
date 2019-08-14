<?php
function quickSort($arr){

    $total = count($arr);
    if ($total <= 1) {
        return $arr;
    }

    $left = $right = [];
    $middle = $arr[0];

    for ($i=1; $i<$total; $i++) {
        if ($arr[$i] > $middle) {
            $right[] = $arr[$i];
        } else {
            $left[] = $arr[$i];
        }
    }

    $left = quickSort($left);
    $right =quickSort($right);

    return array_merge($right, [$middle], $left);

}



$arr = [4,8,2,5,3,9,12,89,43,76,98,3,32,7,9,43];
print_r(quickSort($arr));