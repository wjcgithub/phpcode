<?php
require_once("../../vendor/autoload.php");

use Predis\Client;

function getKeyName($v)
{
    return "mycounter_$v";
}

function getRedisCLient()
{
    return new Client([
        'host' => '127.0.0.1',
        'port' => 6379
    ]);
}

function writeLog($msg, $v)
{
    $log = $msg . PHP_EOL;
    file_put_contents("log/$v.log", $log, FILE_APPEND);
}

function v1()
{
    $amountLimit = 100;
    $keyName = getKeyName('v1');
    $redis = getRedisCLient();
    $incrAmount = 1;

    if (!$redis->exists($keyName)) {
        $redis->set($keyName, 90);
    }
    $currAmount = $redis->get($keyName);
    if ($currAmount + $incrAmount > $amountLimit) {
        writeLog("Bad luck", 'v1');
        return;
    }

    $redis->incrby($keyName, $incrAmount);
    writeLog("Good luck", 'v1');
}

function v2()
{
    $amountLimit = 100;
    $keyName = getKeyName('v2');
    $redis = getRedisCLient();
    $incrAmount = 1;

    if (!$redis->exists($keyName)) {
        $redis->setnx($keyName, 90);
    }

    if ($redis->incrby($keyName, $incrAmount) > $amountLimit) {
        writeLog("Bad luck", 'v2');
        return;
    }

    writeLog("Good luck", 'v2');

}

if ($_GET['v'] == 2) {
    v2();
} else {
    v1();
}