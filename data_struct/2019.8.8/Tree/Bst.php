<?php

include "Node.php";

class Bst {
    public $count;
    public $root;
    public $queue = [];

    public function __construct()
    {
        $this->count = 0;
        $this->root = null;
    }

    public function size()
    {
        return count($this->count);
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

    }

    public function middleOrder()
    {

    }

    public function afterOrder()
    {

    }

    /**
     * 插入节点
     * 如果还没有根节点则当做根节点创建
     * 如果有根节点，并且key值一样则替换
     * 否则判断是放在左还是右节点
     *
     * @param $node
     * @param $key
     * @param $value
     */
    public function __insert(Node &$node, $key, $value)
    {
        //递归退出条件
        if ($node == null) {
            $node = new Node($key, $value);
            $this->count++;
        } else if ($node->key == $key) {
            $node->value = $value;
        } else if ($node->key > $key) {
            $this->__insert($node->left, $key, $value);
        } else {
            $this->__insert($node->right, $key, $value);
        }
    }

    /**
     * 判断某个key是否存在于当前树中
     *
     * @param Node $node
     * @param $key
     * @return bool
     */
    public function __contain(Node $node, $key)
    {
        if ($node == null) {
            return false;
        } else if ($node->key == $key) {
            return true;
        } else if ($node->key > $key) {
            $this->__contain($node->left, $key);
        } else {
            $this->__contain($node->right, $key);
        }
    }

    /**
     * 搜索某个key
     *
     * @param Node $node
     * @param $key
     * @return Node|null
     */
    public function __search(Node $node, $key)
    {
        if ($node == null) {
            return null;
        } else if ($node->key == $key) {
            return $node;
        } else if ($node->key > $key) {
            $this->__search($node->left, $key);
        } else {
            $this->__search($node->right, $key);
        }
    }

    public function
}