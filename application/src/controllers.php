<?php

use Symfony\Component\HttpFoundation\Response;

$app->get( '/', 'controllers.home:get' )->bind('home');

$app->get( '/login', 'controllers.login:get' )->bind('login');
$app->post( '/login', 'controllers.login:post' );
$app->get( '/logout', 'controllers.login:logout' )->bind('logout');

$app->get( '/register', 'controllers.signUp:get' )->bind('register');
$app->post( '/register', 'controllers.signUp:post' );

$app->get( '/articles', 'controllers.home:get' )->bind('articles');
$app->get( '/articles/{article_id}', 'controllers.readArticle:get' )->bind('article');

$app->get( '/writeArticle', 'controllers.writeArticle:get' );
$app->post( '/writeArticle', 'controllers.writeArticle:post' )->bind('writeArticle');

$app->get( '/editArticle/{article_id}', 'controllers.editArticle:get' )->bind('editArticle');
$app->post( '/editArticle/{article_id}', 'controllers.editArticle:post' );

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return null;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html',
        'errors/'.substr($code, 0, 2).'x.html',
        'errors/'.substr($code, 0, 1).'xx.html',
        'errors/default.html',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});