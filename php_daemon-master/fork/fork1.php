<?php
    //创建一个子进程，在父进程中监听子进程，子进程中发送信号给父进程
    declare(ticks=1);

    $pid = pcntl_fork();

    if($pid > 0){
        $a = SIGUSR1;
        echo "parent! \r\n";
        pcntl_waitpid($pid,$a);
        echo "child say it's over!\r\n";
        exit(0);
    } elseif($pid == 0){
        echo "child! \r\n";
        sleep(3);
        echo "child say : my parent pid is : ".posix_getppid()."\r\n";
        echo "child say : my pid is : ".posix_getpid()."\r\n";
        posix_kill(posix_getpid(),SIGUSR1);
        exit(0);
    }