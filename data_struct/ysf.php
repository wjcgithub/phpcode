<?php
/**
* 
*/
define('PNUM', 15);
define('N', 6);

//报数
$call_n = 0;
//出局人数
$out_n = 0;
//自增值
$j = 0;

//init
$personArr=[];
for ($i=0; $i < PNUM; $i++) { 
	$personArr[$i] = 0; 
}

//遍历
while (1) {
	//判断是否出局了,出局则继续
	if ($personArr[$j] == 0) {

		//未出局，是否是最后一个人，最后一个人就赢了
		if ($out_n == (PNUM-1)) {
			echo "$j 赢了\n";
			break;
		}

		$call_n++;
		$call_n %=N;
		if ($call_n == 0) {
			$out_n++;
			print(($j)." 出局 \n");
			$personArr[$j] = 1;
		}
	}


	$j++;
	$j %=PNUM;
}