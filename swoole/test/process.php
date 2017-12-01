<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 17-12-1
 * Time: 下午5:09
 */
class BaseProcess
{
    private $process;

    public function __construct()
    {
        $this->process = new swoole_process([$this, 'run'], false, true);
//        $this->process->daemon(true,true);
        $this->process->start();

        swoole_event_add($this->process->pipe, function ($pipe){
            $data = $this->process->read();
            echo "RECV:". $data.PHP_EOL;
        });
    }

    public function run($worker)
    {
        swoole_timer_tick(1000, function ($timer_id){
            static $index=0;
            $index++;
            $this->process->write("Hello");
            var_dump($index);
            if ($index==10){
                swoole_timer_clear($timer_id);
            }
        });
    }
}

new BaseProcess();
swoole_process::signal(SIGCHLD, function ($sig){
    //必须为false, 设置为非阻塞模式
    while ($ret = swoole_process::wait(false)){
        echo "PID={$ret['pid']}\n";
    }
});

echo "Server Start".PHP_EOL;