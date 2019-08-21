<?php
require_once "./Bst.php";

//$a = new SplQueue();
//$a->push(1);
//$a->push(2);
//$a->push(3);
//
//
//while ($b = $a->shift()){
//    echo $b. "\r\n";
//
//    if ($a->isEmpty()) {
//        break;
//    }
//}
//
//die;


$bst = new Bst();
$bst->insert(20, 20);
$bst->insert(5, 5);
$bst->insert(89, 89);
$bst->insert(55, 55);
$bst->insert(12, 12);
$bst->insert(23, 23);
$bst->insert(8, 8);
$bst->insert(83, 83);
$bst->insert(66, 66);


echo "\r\n";
print_r($bst->contain(3));
echo "\r\n";
print_r($bst->search(88));
echo "\r\n";
echo "前序遍历\r\n";
$bst->preOrder();
//echo "中序遍历\r\n";
//$bst->middleOrder();
//echo "后序遍历\r\n";
//$bst->afterOrder();
echo "广度遍历\r\n";
$bst->levelOrder();