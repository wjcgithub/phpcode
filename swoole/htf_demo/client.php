<?php

$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

$client->on('connect', function ($cli){
    echo "connected\n";
});

$client->on('receive', function ($cli, $data){
    echo "receive: $data\n";
    sleep(1);
    $cli->send("hello\n");
});

$client->on('error', function ($cli){
    echo "Connect false \n";
});

$client->on('close', function ($cli){
    echo "client Close\n";
});

$client->connect('127.0.0.1', 9501);
