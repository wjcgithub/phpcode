<?php
/**
* Double Queue 双向队列
*/
class DoubleQueue
{
	private $queue = [];
	
	//首插
	public function addFirst($value='')
	{
		return array_unshift($this->queue, $value);
	}

	//尾插
	public function addLast($value='')
	{
		return array_push($this->queue, $value);
	}

	//头删
	public function removeFirst($value='')
	{
		# code...
	}
}