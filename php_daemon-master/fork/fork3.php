<?php
    /**
     * Created by PhpStorm.
     * Author: evolution
     * Date: 16-1-14
     * Time: 上午11:23
     *
     * license GPL
     */

//需要安装pcntl的php扩展，并加载它
if(function_exists("pcntl_fork")){
    //生成第一个子进程
    $pid = pcntl_fork();  //$pid即所产生的子进程id
    if($pid == -1){
        //子进程fork失败
        die('could not fork');
    }else{
        if($pid){
            //父进程code
            sleep(5);  //等待5秒
            exit(0); //或$this->_redirect('/');
        }else{
            //第一个子进程code
            //产生孙进程
            if(($gpid = pcntl_fork()) < 0){ ////$gpid即所产生的孙进程id
                //孙进程产生失败
                die('could not fork');
            }elseif($gpid > 0){
                //第一个子进程code，即孙进程的父进程
                $status = 0;
                $status = pcntl_wait($status); //阻塞子进程,并返回孙进程的退出状态，用于检查是否正常退出
                echo "孙进程退出的状态： ".$status."\n";
                if($status != 0) file_put_content('filename', '孙进程异常退出');
                //得到父进程id
                $ppid =  posix_getppid(); //如果$ppid为1则表示其父进程已变为init进程，原父进程已退出
                //得到子进程id：posix_getpid()或getmypid()或是fork返回的变量$pid
                //kill掉子进程
                posix_kill(getmypid(), SIGTERM);
                exit(0);
            }else{ //即$gpid == 0
                //孙进程code
                //....
                //结束孙进程(即当前进程)，以防止生成僵尸进程
                if(function_exists('posix_kill')){
                    posix_kill(getmypid(), SIGTERM);
                }else{
                    system('kill -9'. getmypid());
                }
                exit(0);
            }
        }
    }
}else{
    // 不支持多进程处理时的代码在这里
}
//.....
?>