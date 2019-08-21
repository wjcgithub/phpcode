<?php

Class Node {
    public $key;
    public $value;
    public $left;
    public $right;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}