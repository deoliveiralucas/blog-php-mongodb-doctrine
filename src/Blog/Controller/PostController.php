<?php

namespace DOLucas\Blog\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use DOLucas\Blog\Factory\PostFactory;
use DOLucas\Blog\Service\PostService;

class PostController implements ControllerProviderInterface
{

    /**
     * @see Silex\Api\ControllerProviderInterface
     */
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];

        $controller->get('/post', function () use ($app) {
            $response = $app['service.post']->getAll();

            return $app->json($response);
        });

        $controller->get('/post/{id}', function ($id) use ($app) {
            $response = $app['service.post']->getById($id);

            return $app->json($response);
        });

        $controller->post('/post', function (Request $req) use ($app) {
            $params   = $req->request->all();
            $response = $app['service.post']->create($params);

            return $app->json($response);
        });

        $controller->post('/post/{id}/comment', function ($id, Request $req) use ($app) {
            $params   = $req->request->all();
            $response = $app['service.post']->addComment($id, $params);

            return $app->json($response);
        });
        
        return $controller;
    }
}
