<?php

//总人数
$totalNum = 20;
//需要播报的数
$cycleNum = 6;


//已出人数
$out_n = 0;
//计数器
$calc = 0;
//人员自增值
$j = 0;
//播报到炸弹的数
$dieNum = 2;
$person= [];

//初始化人员
for ($i=0; $i<$totalNum; $i++) {
    $person[$i] = 0;
}

//while (1) {
//    //先判断是否出局了
//    if ($person[$j] == 0) {  //没出局
//        //判断是否是最后一个人，最后一个人就赢了
//        if ($out_n == $totalNum-1) {
//            echo "$j 赢了\r\n";
//            break;
//        }
//
//        //不是最后一个人，就继续报数
//        $calc++;
//        $calc%=$cycleNum;
//        if ($calc == $dieNum){
//            echo "$j 出局 \r\n";
//            $out_n++;
//            //标记为出局
//            $person[$j] = 1;
//        }
//
//    }
//
//    //下一个人
//    $j++;
//    $j%=$totalNum;
//}

echo "=======\r\n";

while (1) {
    //判断是否出局
    if ($person[$j] ==0 ) { //没出局
        //判断是否是最后一个人，如果是那么他就赢了
        if ($out_n == $totalNum-1) {
            echo "$j 赢了\r\n";
            break;
        }

        //继续报数
        $calc++;
        $calc%=$cycleNum;
        if ($calc == $dieNum) {
            echo "$j 出局\r\n";
            $out_n++;
            $person[$j]=1;
        }
    }


    //继续下一个人, 如果达到最大值，从0在开始
    $j++;
    $j%=$totalNum;
}