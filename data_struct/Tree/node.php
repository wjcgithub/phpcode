<?php

/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 18-4-17
 * Time: 上午10:41
 */
class Node
{
    public $key='';
    public $value='';
    public $left = null;
    public $right = null;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}