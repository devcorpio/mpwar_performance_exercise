<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Snc\RedisBundle\Session\Storage\Handler;

$app = new Application();

$app->register(new Performance\DomainServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new DoctrineServiceProvider);
$app->register(new DoctrineOrmServiceProvider);

$app['redis'] = new Predis\Client([
    'host' => 'redis',
    'database' => 0
]);
$app['session.storage.handler'] = new Handler\RedisSessionHandler($app['redis']);

return $app;
