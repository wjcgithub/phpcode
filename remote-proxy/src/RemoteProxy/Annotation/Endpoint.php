<?php

namespace RemoteProxy\Annotation;

/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 18-4-4
 * Time: 下午3:46
 */
class Endpoint
{
    public $path;
    public $method;

    public function __construct($parameters)
    {
        $this->path = $parameters['path'];
        $this->method = isset($parameters['method']) ? $parameters['method'] : 'get';
    }
}