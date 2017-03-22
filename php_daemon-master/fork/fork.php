<?php
    $pid = pcntl_fork();

    if($pid > 0){
        echo "parent! \r\n";
        exit(0);
    } elseif($pid == 0){
        echo "child! \r\n";
        exit(0);
    }