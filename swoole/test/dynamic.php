<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 17-12-1
 * Time: 下午5:47
 */
class BaseProcess
{
    private $process;
    private $process_list = [];
    private $process_use = [];
    private $min_worker_num = 3;
    private $max_worker_num = 6;
    private $current_worker_num;

    public function __construct()
    {
        $this->process = new swoole_process([$this, 'run'], false, 2);
        $this->process->start();

        swoole_process::wait();
    }

    public function run($worker)
    {
        $this->current_worker_num = $this->min_worker_num;

        for ($i=0; $i<$this->current_worker_num; $i++) {
            $process = new swoole_process([$this, 'task_run'], false, 2);
            $pid = $process->start();
            $this->process_list[$pid] = $process;
            $this->process_use[$pid] = 0;
        }

        foreach ($this->process_list as $pid => $process){
            swoole_event_add($process->pipe, function ($pipe) use ($process){
               $data = $process->read();
                var_dump($data);
                $this->process_use[$process->pid] = 0;
            });
        }


        swoole_timer_tick(1000, function ($timer_id){
            static $index=0;
            $index++;
            $flag = true;
            foreach ($this->process_use as $pid => $used){
                if ($used==0){
                    $flag = false;
                    $this->process_use[$pid] = 1;
                    $this->process_list[$pid]->write($index. " Hello");
                    break;
                }
            }

            //如果没有可用进程处理请求，并且还没有达到最大进程数那么就创建新的进程
            if (!$flag && $this->current_worker_num < $this->max_worker_num){
                $process = new swoole_process([$this, 'task_run'], false, 2);
                $pid = $process->start();
                $this->process_list[$pid] = $process;
                $this->process_use[$pid] = 1;
                $this->process_list[$pid]->write($index . " Hello");
                $this->current_worker_num++;
            }
            var_dump($index);
            if ($index == 10) {
                //退出所有的子进程
                foreach ($this->process_list as $process) {
                    $process->write('exit');
                }
                swoole_timer_clear($timer_id);
                $this->process->exit();
            }
        });
    }

    public function task_run($worker)
    {
        swoole_event_add($worker->pipe, function ($pipe) use ($worker){
            $data = $worker->read();
            var_dump($worker->pid.":".$data);
            if ($data == 'exit') {
                $worker->exit();
                exit;
            }
            sleep(5);
            $worker->write(" ". $worker->pid);
        });
    }
}

new BaseProcess();
//
//swoole_process::signal(SIGCHLD, function ($sig){
//    //必须为false, 设置为非阻塞模式
//    while ($ret = swoole_process::wait(false)){
//        echo "PID={$ret['pid']}\n";
//    }
//});

echo "Server Start".PHP_EOL;