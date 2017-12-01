<?php

/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 17-4-21
 * Time: 上午11:09
 */
class DBServer
{
    protected $pool_size = 20;
    protected $idle_pool = [];
    protected $busy_pool = [];
    protected $wait_queue = [];
    protected $wait_queue_max = 100;

    protected $serv;

    public function run()
    {
        $serv = new \Swoole\Server('127.0.0.1', 9509);
        $serv->set([
            'worker_num' => 1,
        ]);

        $serv->on('WorkerStart', [$this, 'onStart']);
        //$serv->on('Connect', array($this, 'onConnect'));
        $serv->on('Receive', [$this, 'onReceive']);
        //$serv->on('Close', array($this, 'onClose'));
        $serv->start();
    }

    public function onStart($serv)
    {
        $this->serv = $serv;
        for ($i = 0; $i < $this->pool_size; $i++) {
            $db = new \mysqli;
            $db->connect('127.0.0.1', 'root', 'root', 'test');
            $db_sock = swoole_get_mysqli_sock($db);
            swoole_event_add($db_sock, [$this, 'onSQLReady']);
            $this->idle_pool[] = [
                'mysqli' => $db,
                'db_sock' => $db_sock,
                'fd' => 0,
            ];
        }
        echo "Server: start.Swoole version is [" . SWOOLE_VERSION . "]\n";
    }
}
