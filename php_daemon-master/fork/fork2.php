<?php
    //子进程在输出child process等字样之后sleep了2秒才结束，而父进程阻塞着直到子进程退出之后才继续运行。
    $pid = pcntl_fork();
    if($pid) {
        pcntl_wait($status);
        $id = getmypid();
        echo "parent process,pid {$id}, child pid {$pid}\n";
    }else{
        $id = getmypid();
        echo $pid."\n";
        echo "child process,pid {$id}\n";
        sleep(2);
    }