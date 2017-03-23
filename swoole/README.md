# Swoole 笔记

## 编译安装
```powershell
git clone https://github.com/swoole/swoole-src.git
cd swoole-src
git co v2.0.6   |   git co v1.9.8
phpize
./configure
make && make install
vi /path/to/php.ini
add extension=swoole.so
```

## 查看Swoole版本
`php -ri swoole`

##编程须知

### 注意事项
1. 不要在代码中执行`sleep`以及其他睡眠函数，这样会导致整个进程阻塞
2. `exit/die`是危险的，会导致worker进程退出
3. 可通过`register_shutdown_function`来捕获致命错误，在进程异常退出时做一些请求工作，具体参考[https://wiki.swoole.com/wiki/page/305.html](https://wiki.swoole.com/wiki/page/305.html)
4. PHP代码中如果有异常抛出，必须在回调函数中进行`try/catch`捕获异常，否则会导致工作进程退出
5. swoole不支持`set_exception_handler`, 必须使用`try/catch`方式处理异常
6. Worker进程不得共用同一个`Redis` 或`MySql`等网络服务客户端，Redis/MySql创建连接的相关代码可以放到`onWorkerStart`回调函数中，具体参考[https://wiki.swoole.com/wiki/page/325.html](https://wiki.swoole.com/wiki/page/325.html)

### 异步编程
1. 异步程序要求代码中不得包含任何同步阻塞操作
2. 异步与同步代码不能混用，一旦应用程序使用了任何同步阻塞的代码，程序即退化为同步模式

## task进程使用消息队列
[https://wiki.swoole.com/wiki/page/212.html](https://wiki.swoole.com/wiki/page/212.html)

## Swoole进程模型
```php
<?php
$server = new \Swoole\Server('127.0.0.1', 8088, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
$server->on('connect', function ($serv, $fd){});
$server->on('receive', function ($serv, $fd){});
$server->on('close', function ($serv, $fd){});
$server->start();
```

#### 查看进程树
`pstree -ap | grep service`
![Alt text](./1490263779505.png)

Master: 15455
Manager: 15456
Worker: 15465-15472

#### 基于此，我们简单梳理一下，当执行的start方法之后，发生了什么
1. `守护进程`模式下，当前进程fork出`Master进程`，然后退出，Master进程触发`OnMasterStart`事件。
2. `Master进程`启动成功之后，fork出`Manager进程`，并触发`OnManagerStart`事件。
3. `Manager进程`启动成功时候，fork出`Worker进程`，并触发`OnWorkerStart`事件。

> 非守护进程模式下，则当前进程直接作为Master进程工作

- 所以，一个最基础的Swoole Server，至少需要有3个进程，分别是`Master`进程、`Manager`进程和`Worker`进程
- 事实上，一个多进程模式下的Swoole Server中，有且只有`一个Master进程`；有且只有`一个Manager进程`；却可以有`n`个`Worker进程`

![Alt text](./1490267413417.png)

### 这几个进程是如何协同工作的
1. Client主动Connect的时候，Client实际上是与Master进程中的某个Reactor线程发生了连接。
2. 当TCP的三次握手成功了以后，由这个Reactor线程将连接成功的消息告诉Manager进程，再由Manager进程转交给Worker进程。
3. 在这个Worker进程中触发了OnConnect的方法。
4. 当Client向Server发送了一个数据包的时候，首先收到数据包的是Reactor线程，同时Reactor线程会完成组包，再将组好的包交给Manager进程，由Manager进程转交给Worker。
5. 此时Worker进程触发OnReceive事件。
6. 如果在Worker进程中做了什么处理，然后再用Send方法将数据发回给客户端时，数据则会沿着这个路径逆流而上。

> 同样的故事，随着认识的加深，会发现不一样的精彩

首先，Master进程是一个多线程进程，其中有一组非常重要的线程，叫做Reactor线程（组），每当一个客户端连接上服务器的时候，都会由Master进程从已有的Reactor线程中，根据一定规则挑选一个，专门负责向这个客户端提供维持链接、处理网络IO与收发数据等服务。

![Alt text](./1490268413504.png)

> 以前我们提到的分包拆包等功能也是在这里完成的哦。

而Manager进程，某种意义上可以看做一个代理层，它本身并不直接处理业务，其主要工作是将Master进程中收到的数据转交给Worker进程，或者将Worker进程中希望发给客户端的数据转交给Master进程进行发送。

另外，Manager进程还负责监控Worker进程，如果Worker进程因为某些意外挂了，Manager进程会重新拉起新的Worker进程，有点像Supervisor的工作

> 而这个特性，也是最终实现热重载的核心机制。

最后就是Worker进程了，顾名思义，Worker进程其实就是处理各种业务工作的进程，Manager将数据包转交给Worker进程，然后Worker进程进行具体的处理，并根据实际情况将结果反馈给客户端。

如果要打个比方的话，Master进程就像业务窗口的，Reactor就是前台接待员，用户很多的时候，后边的用户就需要排队等待服务；Reactor负责与客户直接沟通，对客户的请求进行初步的整理（传输层级别的整理——组包）；然后，Manager进程就是类似项目经理的角色，要负责将业务分配给合适的Worker（例如空闲的Worker）；而Worker进程就是工人，负责实现具体的业务。

> 实际上，一对多投递这种模式总是在`并发的程序设计`非常常见：1个Master进程投递n个Reactor线程；1个Manager进程投递n个Worker进程。

- `nginx -> worker_processes num|auto`  ==>  `fastcgi_pass | upstream`   ==>  `pm.max_children`
![Alt text](./1490268078395.png)
![Alt text](./1490268098156.png)
![Alt text](./1490268143898.png)


### 明白了以上的内容在回过头看`Swoole Server`的配置
