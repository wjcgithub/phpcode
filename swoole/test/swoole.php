<?php
class Server{
	private $serv;
	private $test;
	
	public function __construct()
	{
		$this->serv = new \Swoole\Server('0.0.0.0', 9501);
		$this->serv->set([
			'worker_num' => 1
		]);

		$this->serv->on('Start', [$this, 'onStart']);
		$this->serv->on('Connect', [$this, 'onConnect']);
		$this->serv->on('Receive', [$this, 'onReceive']);
		$this->serv->on('CLose', [$this, 'onCLose']);

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

	public function onReceive($serv, $fd, $from_id, $data)
	{
		echo "Get Message From Client {$fd}:{$data}\n";
		foreach ($serv->connections as $client) {
			if ($fd != $client) {
				$serv->send($client, $data);
			}
		}
		echo "Client {$fd} Received, data is {$data}\n";
	}

	public function onClose($serv, $fd, $from_id)
	{
		echo "Client {$fd} close connect\n";
	}	
}

$serv = new Server();