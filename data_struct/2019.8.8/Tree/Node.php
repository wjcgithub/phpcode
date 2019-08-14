<?php

Class Node {
    private $key;
    private $value;
    public $left;
    public $right;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}