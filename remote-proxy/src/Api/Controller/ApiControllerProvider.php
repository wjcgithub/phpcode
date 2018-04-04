<?php
namespace Api\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse as Json;

class ApiControllerProvider implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        /**
         * Return a list of the books
         */
        $controllers->get('books', function (Application $app) {

            return new Json([
                'books' => 'List of books...'
            ]);
        });

        /**
         * Return book details by Id
         */
        $controllers->get('books/{id}', function (Application $app, $id) {

            return new Json([
                'details' => 'Details of book with id ' . $id,
            ]);
        });

        /**
         * Return the author(s) of the book
         */
        $controllers->get('books/{id}/authors', function (Application $app, $id) {

            return new Json([
                'authors' => 'Authors of book with id ' . $id,
            ]);
        });

        return $controllers;
    }
}