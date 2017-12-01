<?php
$server = new swoole_server('0.0.0.0', 9501);

$server->on('connect', function (swoole_server $serv, $fd, $from_id){
    echo "Connected \n";
    $serv->send($fd, "From_id is $from_id, Hello\n");
});

$server->on('receive', function(swoole_server $serv, $fd,  $from_id, $data){
    echo "Received: $data From_id $from_id\n";
    $serv->send($fd, "Server Say: From_id is $from_id, data is $data");
});

$server->on('close', function ($serv, $fd, $from_id){
    echo "Closed\n";
});


$server->start();