<?php
include './vendor/autoload.php';
$client = new \GuzzleHttp\Client();
//$res = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');
//$res = $client->request('POST', 'https://api.github.com/repos/guzzle/guzzle');
//echo $res->getStatusCode()."\r\n";
// 200
//echo $res->getHeaderLine('content-type')."\r\n";
// 'application/json; charset=utf8'
//echo $res->getBody();
// '{"id": 1420053, "name": "guzzle", ...}'



$response = $client->request('POST', 'https://www.sky2628.com/System/Security/hylogin.aspx', [
    'form_params' => [
        'field_name' => 'abc',
        'other_field' => '123',
        'nested_field' => [
            'nested' => 'hello'
        ]
    ]
]);

echo $response->getBody();