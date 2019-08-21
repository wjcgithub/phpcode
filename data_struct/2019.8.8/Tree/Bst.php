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
        $this->__levelOrder($this->root);
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
    public function __insert(Node &$node=null, $key, $value)
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
    public function __contain(Node $node = null, $key)
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

    /**
     * 搜索某个key
     *
     * @param Node $node
     * @param $key
     * @return Node|null
     */
    public function __search(Node $node = null, $key)
    {
        if ($node == null) {
            return null;
        } else if ($node->key == $key) {
            return $node;
        } else if ($node->key > $key) {
            return $this->__search($node->left, $key);
        } else {
            return $this->__search($node->right, $key);
        }
    }

    public function __preOrder(Node $node = null)
    {
        if ($node != null) {
            echo "key: $node->key  value: $node->value". PHP_EOL;
            $this->__preOrder($node->left);
            $this->__preOrder($node->right);
        }
    }

    public function __middleOrder(Node $node = null)
    {
        if ($node != null) {
            $this->__middleOrder($node->left);
            echo "key: $node->key  value: $node->value". PHP_EOL;
            $this->__middleOrder($node->right);
        }
    }

    public function __afterOrder(Node $node = null)
    {
        if ($node != null) {
            $this->__afterOrder($node->left);
            $this->__afterOrder($node->right);
            echo "key: $node->key  value: $node->value". PHP_EOL;
        }
    }

    public function __levelOrder(Node $node = null)
    {
        $queue = new SplQueue();
        if ($node == null) return;

        $queue->enqueue($node);
        while ($theNode = $queue->shift()) {
            echo "node $theNode->value , ";
            if (!empty($theNode->left)){
                $queue->enqueue($theNode->left);
            }

            if(!empty($theNode->right)) {
                $queue->enqueue($theNode->right);
            }

            if ($queue->isEmpty()) {
                break;
            }
        }
    }
}

