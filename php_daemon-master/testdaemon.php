<?php
    // 创建一个守护进程，然后到指定时间之后自动自杀并退出
    function daemonize()
    {
        $pid = pcntl_fork();
        if ($pid == -1)
        {
            die("fork(1) failed!\n");
        }
        elseif ($pid > 0)
        {
            //让由用户启动的进程退出
            sleep(1);
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
            sleep(1);
            exit(0);
        }else{
            $i = 10;
            while ($i){
                $i--;
                echo $i."\r\n";
                sleep(1);
            }

            posix_kill($pid,SIGKILL);
        }
    }

    daemonize();
    sleep(1000);