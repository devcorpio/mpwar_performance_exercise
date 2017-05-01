<?php

namespace Performance;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DomainServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['useCases.signUp'] = function () use ($app) {
            return new \Performance\Domain\UseCase\SignUp($app['orm.em']->getRepository('Performance\Domain\Author'));
        };

        $app['useCases.login'] = function () use ($app) {
            return new \Performance\Domain\UseCase\Login($app['orm.em']->getRepository('Performance\Domain\Author'), $app['session']);
        };

        $app['useCases.writeArticle'] = function () use ($app) {
            return new \Performance\Domain\UseCase\WriteArticle($app['orm.em']->getRepository('Performance\Domain\Article'), $app['orm.em']->getRepository('Performance\Domain\Author'), $app['session']);
        };

        $app['useCases.editArticle'] = function () use ($app) {
            return new \Performance\Domain\UseCase\EditArticle($app['orm.em']->getRepository('Performance\Domain\Article'), $app['orm.em']->getRepository('Performance\Domain\Author'), $app['session']);
        };

        $app['useCases.readArticle'] = function () use ($app) {
            return new \Performance\Domain\UseCase\ReadArticle($app['orm.em']->getRepository('Performance\Domain\Article'));
        };

        $app['useCases.listArticles'] = function () use ($app) {
            return new \Performance\Domain\UseCase\ListArticles($app['orm.em']->getRepository('Performance\Domain\Article'));
        };

        $app['controllers.readArticle'] = function () use ($app) {
            return new \Performance\Controller\ArticleController($app['twig'], $app['useCases.readArticle']);
        };

        $app['controllers.writeArticle'] = function () use ($app) {
            return new \Performance\Controller\WriteArticleController($app['twig'], $app['url_generator'], $app['useCases.writeArticle'], $app['session']);
        };

        $app['controllers.editArticle'] = function () use ($app) {
            return new \Performance\Controller\EditArticleController($app['twig'], $app['url_generator'], $app['useCases.editArticle'], $app['useCases.readArticle'], $app['session']);
        };

        $app['controllers.login'] = function () use ($app) {
            return new \Performance\Controller\LoginController($app['twig'], $app['url_generator'], $app['useCases.login'], $app['session']);
        };

        $app['controllers.signUp'] = function () use ($app) {
            return new \Performance\Controller\RegisterController($app['twig'], $app['url_generator'], $app['useCases.signUp']);
        };

        $app['controllers.home'] = function () use ($app) {
            return new \Performance\Controller\HomeController($app['twig'], $app['useCases.listArticles']);
        };
    }
}