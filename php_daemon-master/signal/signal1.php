<?php
    declare(ticks = 2);
    function sig_handler($signo){
        switch ($signo){
            case SIGUSR1:
                echo "SIGUSR1\r\n";
                break;

            case SIGUSR2:
                echo "SIGUSR2\r\n";
                break;
            default:
                echo 'unknow';
                break;
        }
    }

    pcntl_signal(SIGUSR1,"sig_handler");
    pcntl_signal(SIGUSR2,"sig_handler");

    posix_kill(posix_getpid(),SIGUSR1);
    posix_kill(posix_getpid(),SIGUSR2);
