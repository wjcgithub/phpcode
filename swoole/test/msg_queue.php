<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 17-12-1
 * Time: 下午5:31
 */

class BaseProcess
{
    private $process;

    public function __construct()
    {
        $this->process = new swoole_process([$this, 'run'], false, true);

        //创建消息队列
        if (!$this->process->useQueue(123)){
            var_dump(swoole_strerror(swoole_errno()));
            exit;
        }

        $this->process->start();

        while (1) {
            $data = $this->process->pop();
            echo "RECV:". $data. PHP_EOL;
        }
    }

    public function run($worker)
    {
        swoole_timer_tick(1000, function ($timer_id){
            static $index=0;
            $index++;
            $this->process->push("Hello");
            var_dump($index);
            if ($index==10){
                swoole_timer_clear($timer_id);
            }
        });
    }
}

new BaseProcess();

//因为用队列获取信息，队列是同步执行的，所以这里根本不会执行到
swoole_process::signal(SIGCHLD, function ($sig){
    //必须为false, 设置为非阻塞模式
    while ($ret = swoole_process::wait(false)){
        echo "PID={$ret['pid']}\n";
    }
});

echo "Server Start".PHP_EOL;