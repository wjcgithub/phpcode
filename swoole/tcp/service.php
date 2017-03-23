<?php
$server = new \Swoole\Server('127.0.0.1', 8088, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
var_dump($server);
$server->on('connect', function ($serv, $fd){

});

$server->on('receive', function ($serv, $fd){
	
});

$server->on('close', function ($serv, $fd){
	
});

$server->start();