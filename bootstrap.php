<?php

require_once __DIR__ . '/vendor/autoload.php';

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

$app = new Application();
$app['debug'] = true;

$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/res/views',
]);

AnnotationDriver::registerAnnotationClasses();

$config = new Configuration();
$config->setProxyDir('/tmp');
$config->setProxyNamespace('Proxies');
$config->setHydratorDir('/tmp');
$config->setHydratorNamespace('Hydrators');
$config->setMetadataDriverImpl(AnnotationDriver::create('/tmp'));
$config->setDefaultDB('doctrineblog');

$dm = DocumentManager::create(new Connection(), $config);