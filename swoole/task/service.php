<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 17-4-6
 * Time: 上午9:56
 */
class Server
{
    private $serv;
    public function __construct()
    {
        $this->serv = new swoole_server("0.0.0.0", 9501);
        $this->serv->set([
            'worker_num' => 8,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode'=> 1,
            'task_worker_num' => 8
        ]);
        $this->serv->on('Start', [$this, 'onStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'onReceive']);
        $this->serv->on('Close', [$this, 'onClose']);
        // bind callback
        $this->serv->on('Task', [$this, 'onTask']);
        $this->serv->on('Finish', [$this, 'onFinish']);
        $this->serv->start();
    }
    public function onStart($serv)
    {
        echo "Start\n";
    }
    public function onConnect($serv, $fd, $from_id)
    {
        echo "Client {$fd} connect\n";
    }
    public function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        echo "Get Message From Client {$fd}:{$data}\n";
        // send a task to task worker.
        $param = [
            'fd' => $fd
        ];
        $serv->task(json_encode($param));
        echo "Continue Handle Worker\n";
    }
    public function onClose($serv, $fd, $from_id)
    {
        echo "Client {$fd} close connection\n";
    }
    public function onTask($serv, $task_id, $from_id, $data)
    {
        echo "This Task {$task_id} from Worker {$from_id}\n";
        echo "Data: {$data}\n";
        for ($i = 0 ; $i < 10 ; $i ++) {
            sleep(1);
            echo "Taks {$task_id} Handle {$i} times...\n";
        }
        $fd = json_decode($data, true)['fd'];
        $serv->send($fd, "Data in Task {$task_id}");
        return "Task {$task_id}'s result";
    }
    public function onFinish($serv, $task_id, $data)
    {
        echo "Task {$task_id} finish\n";
        echo "Result: {$data}\n";
    }
}
$server = new Server();
