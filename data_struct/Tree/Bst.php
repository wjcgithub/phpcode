<?php
include_once 'node.php';

/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 18-4-17
 * Time: 上午10:39
 */
class Bst
{
    private $count;
    private $root;
    private $queue = [];

    public function __construct()
    {
        $this->count = 0;
        $this->root = null;
    }

    public function size()
    {
        return $this->count;
    }

    public function isEmpty()
    {
        return $this->count == 0;
    }

    public function insert($key, $value)
    {
        $this->__insert($this->root, $key, $value);
    }

    public function contain($key)
    {
        return $this->__contain($this->root, $key);
    }

    public function search($key)
    {
        return $this->__search($this->root, $key);
    }

    public function preOrder()
    {
        $this->__preOrder($this->root);
    }

    public function middleOrder()
    {
        $this->__middleOrder($this->root);
    }

    public function afterOrder()
    {
        $this->__afterOrder($this->root);
    }

    public function levelOrder()
    {
        $this->__levelOrder();
    }

    public function getTree()
    {
        print_r($this->root);
    }

    public function delete()
    {

    }

    private function __insert(&$node, $key, $value)
    {
        if ($node == null) {
            $this->count++;
            $node = new Node($key, $value);
        } else if ($node->key == $key) {
            $node->value = $value;
        } else if ($node->key > $key) {
            $this->__insert($node->left, $key, $value);
        } else {
            $this->__insert($node->right, $key, $value);
        }

        return $node;
    }

    private function __contain($node, $key)
    {
        if ($node == null) {
            return false;
        } else if ($node->key == $key) {
            return true;
        } else if ($node->key > $key) {
            return $this->__contain($node->left, $key);
        } else {
            return $this->__contain($node->right, $key);
        }
    }

    private function __search($node, $key)
    {
        if ($node == null) {
            return false;
        } else if ($node->key == $key) {
            return $node;
        } else if ($node->key > $key) {
            return $this->__search($node->left, $key);
        } else {
            return $this->__search($node->right, $key);
        }
    }

    private function __preOrder($node)
    {
        if ($node!=null){
            echo 'key:'.$node->key.'--value:'.$node->value."\r\n";
            $this->__preOrder($node->left);
            $this->__preOrder($node->right);
        }
    }

    private function __middleOrder($node)
    {
        if ($node!=null){
            $this->__middleOrder($node->left);
            echo 'key:'.$node->key.'--value:'.$node->value."\r\n";
            $this->__middleOrder($node->right);
        }
    }

    private function __afterOrder($node)
    {
        if ($node!=null){
            $this->__afterOrder($node->left);
            $this->__afterOrder($node->right);
            echo 'key:'.$node->key.'--value:'.$node->value."\r\n";
        }
    }

    private function __levelOrder()
    {
        array_push($this->queue, $this->root);

        while(count($this->queue)) {
            $t = array_shift($this->queue);
            echo $t->key."--";
            if ($t->left){
                array_push($this->queue, $t->left);
            }
            if ($t->right){
                array_push($this->queue, $t->right);
            }
        }
    }
}

$bst = new Bst();
$bst->insert(20, '20');
$bst->insert(1, 'A');
$bst->insert(2, 'B');
$bst->insert(55, 55);
$bst->insert(3, 'C');
$bst->insert(2, '2B');
$bst->insert(8, '8');
$bst->insert(88, '88');
$bst->insert(66, '66');

echo "\r\n";
print_r($bst->contain(3));
echo "\r\n";
print_r($bst->search(4));
echo "\r\n";
echo "前序遍历\r\n";
$bst->preOrder();
echo "中序遍历\r\n";
$bst->middleOrder();
echo "后序遍历\r\n";
$bst->afterOrder();
echo "\r\n";
echo "广度优先遍历";
$bst->levelOrder();