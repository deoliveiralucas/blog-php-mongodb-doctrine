<?php

require_once __DIR__ . '/../bootstrap.php';

use DOLucas\Blog\Controller\IndexController;
use DOLucas\Blog\Controller\PostController;
use DOLucas\Blog\Controller\CommentController;
use DOLucas\Blog\Service\PostService;
use DOLucas\Blog\Repository\PostRepository;
use DOLucas\Blog\Validator\PostValidator;
use DOLucas\Blog\Validator\CommentValidator;
use DOLucas\Blog\Factory\PostFactory;
use DOLucas\Blog\Factory\CommentFactory;

$app['service.post'] = function() use ($app, $dm) {
    $postService = new PostService(
        new PostRepository($dm),
        new PostFactory(), 
        new CommentFactory(),
        new PostValidator(),
        new CommentValidator()
    );
    return $postService;
};

// Client
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig');
});

$app->get('/post/create', function () use ($app) {
    return $app['twig']->render('create.twig');
});

$app->get('/post/{id}', function ($id) use ($app) {
    return $app['twig']->render('post.twig', [
        'idPost' => $id
    ]);
});

// API
$app->mount('/api', new PostController());

$app->run();