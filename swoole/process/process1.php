<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 17-4-6
 * Time: 上午10:33
 */
class MyProcess
{
    //master进程id
    public $mpid=0;
    //子进程worker数组
    public $works=[];
    //最大子进程数
    public $max_process=5;
    //子进程索引号码
    public static $new_index=0;

    public function __construct()
    {
        try {
            swoole_set_process_name(sprintf('php-ps:%s', 'master'));
            $this->mpid = posix_getpid();
            $this->run();
            $this->processWait();
        } catch (\Exception $e) {
            die('ALL ERROR: '. $e->getMessage());
        }
    }

    public function run()
    {
        for ($i=0; $i<$this->max_process; $i++) {
            $process = $this->CreateProcess();
        }
    }

    public function CreateProcess($index=null)
    {
        if (is_null($index)) {
            $index = self::$new_index;
            self::$new_index++;
        }

        $process = new Swoole\Process(function (Swoole\Process $worker) use ($index) {
            //设置子进程名字
            swoole_set_process_name(sprintf('php-ps:%s', $index));

            for ($j=0; $j<10; $j++) {
                $this->checkMpid($worker);
                echo "msg: {$j}\n";
                sleep(1);
            }
        }, 1, 1);

        swoole_event_add($process->pipe, function ($pipe) use ($process) {
            $recv = $process->read();
            $fd = fopen('/tmp/process.txt', 'a');
            $str = "{$process->pid}　－－　{$recv} --  \n";
            fwrite($fd, $str);
            fclose($fd);
        });

        $pid = $process->start();


        $this->works[$index] = $pid;
        return $process;
    }

    /**
     * 判断如果主进程退出了，那么子进程要主动退出
     * @param $worker
     */
    public function checkMpid(&$worker)
    {
        if (!Swoole\Process::kill($this->mpid, 0)) {
            $worker->exit();
            echo "Master process exited, I [{$worker['pid']} also quit\n]";
        }
    }

    /**
     * 重启进程
     * @param $ret
     */
    public function rebootProcess($ret)
    {
        $pid = $ret['pid'];
        $index = array_search($pid, $this->works);
        if ($index !== false) {
            $index=intval($index);
            $process=$this->CreateProcess($index);
            echo "rebootProcess: {$index}={$process->pid} Done\n";
            return;
        }
    }

    /**
     * 回收结束运行的子进程
     */
    public function processWait()
    {
        while (1) {
            if (count($this->works)) {
                $ret = Swoole\Process::wait();
                if ($ret) {
                    $this->rebootProcess($ret);
                }
            } else {
                break;
            }
        }
    }
}

new MyProcess();
