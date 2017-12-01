<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 17-5-17
 * Time: 上午10:49
 */


$process = new \Swoole\Process(function (\Swoole\Process $worker) {
    swoole_timer_tick(1000, function () {
        //检测父进程是否存活
        $j=0;
        \Swoole\Coroutine::create(function () use ($j) {
            \SeasLog::setLogger('coroutine');
            \SeasLog::info($j++);
        });

        echo date('h:i:s')."\n";
    });
}, false, false);

$pid=$process->start();
