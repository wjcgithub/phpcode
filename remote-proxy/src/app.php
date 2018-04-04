<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 18-4-4
 * Time: 下午3:19
 */

use RemoteProxy\LibraryInterface;
use RemoteProxy\RestProxyFactory;
use Silex\Application;
use Api\Controller\ApiControllerProvider;
use Symfony\Component\HttpFoundation\JsonResponse;

$app = new Application();
$app->mount('/api/v1', new ApiControllerProvider());

$app->get('test-proxy', function (Application $app) {

    try{
        $proxy = RestProxyFactory::create(LibraryInterface::class, 'http://localhost:8099/api/v1');
        return new JsonResponse([
            'books' => $proxy->getBook(1),
        ]);
    }catch (\Exception $e){
        echo $e->getMessage();
    }
});


return $app;