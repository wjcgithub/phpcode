<?php
    /**
     * 使一个php程序变成daemon进入后台运行
     *
     * @author evolution <wjc163@sina.cn>
     * @param $a String test.
     * @return  int
     * @version 1.0.1
     * @license GPL
     */
    function daemonize($a){
        $pid = pcntl_fork();
        if ($pid == -1)
        {
            die("fork(1) failed!\n");
        }
        elseif ($pid > 0)
        {
            //让由用户启动的进程退出
            exit(0);
        }

        //建立一个有别于终端的新session以脱离终端
        posix_setsid();

        $pid = pcntl_fork();
        if ($pid == -1)
        {
            die("fork(2) failed!\n");
        }
        elseif ($pid > 0)
        {
            //父进程退出, 剩下子进程成为最终的独立进程
            exit(0);
        }
    }

    daemonize();
    sleep(1000);


    /**
     * @param int    $a
     * @param string $b
     * @param        $c
     *
     * @return string
     */
    function aa($a=1,$b='test',$c){
        $a =   $a;
        return json_encode(array(1,2,3));
    }