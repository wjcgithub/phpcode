<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 17-11-27
 * Time: 上午11:58
 */
$http = new swoole_http_server('0.0.0.0', 9501);
$http->set([
    'worker_num'=>16,
    'daemonize'=>1
]);
$http->on('request', function (swoole_http_request $request, swoole_http_response $response) {

    $pathinfo = $request->server['path_info'];
    $filename = __DIR__.$pathinfo;

    if (is_file($filename)) {
        $ext = pathinfo($pathinfo, PATHINFO_EXTENSION);
        if ('php' == $ext) {
            ob_start();
            include $filename;
            $content = ob_get_contents();
            ob_end_clean();
            $response->end($content);
        } else {
            $mimes = include "mimes.php";
            $response->header('Content-Type', $mimes[$ext]);
            $content = file_get_contents($filename);
            $response->end($content);
        }
    } else {
        $response->status(404);
        $response->end('404 not found');
    }

});
$http->start();