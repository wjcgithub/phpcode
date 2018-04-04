<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 18-4-4
 * Time: 下午4:25
 */

namespace RemoteProxy;

use Doctrine\Common\Annotations\AnnotationRegistry;
use RemoteProxy\Adapter\RestAdapter;

class RestProxyFactory
{
    public static function create($interface, $base_uri)
    {
        // Registering a silent autoloader for the annotation
        AnnotationRegistry::registerLoader('class_exists');
        $factory = new \ProxyManager\Factory\RemoteObjectFactory(
            new RestAdapter(
                new \GuzzleHttp\Client([
                    'base_uri' => rtrim($base_uri, '/') . '/',
                ]),
                [
                    'getBooks'   => ['path' => 'books',             'method' => 'get'],
                    'getBook'    => ['path' => 'books/:id',         'method' => 'get'],
                    'getAuthors' => ['path' => 'books/:id/authors', 'method' => 'get'],
                ]
            )
        );

        return $factory->createProxy($interface);
    }
}