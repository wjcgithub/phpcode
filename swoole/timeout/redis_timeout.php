<?php
require_once "../../vendor/autoload.php";

Predis\Autoloader::register();

$client = new Predis\Client('tcp://127.0.0.1:6379');
$client->set("k", "v");
sleep(5);
var_dump($client->get("k"));