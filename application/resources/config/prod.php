<?php

date_default_timezone_set('Europe/Madrid');

$app['twig.path'] = array(__DIR__ . '/../templates');
$app['twig.options'] = [];

$app['db.options'] = [
    "driver"    => "pdo_mysql",
    "host"      => 'mysql',
    "user"      => 'root',
    "password"  => 'root',
    "dbname"    => 'mpwar_performance_blog',
    "charset"   => "utf8"
];
$app['orm.proxies_dir'] = '/tmp/proxies';
$app['orm.auto_generate_proxies'] = true;
$app['orm.em.options'] = [
    "mappings" => [
        [
            "type" => "simple_yml",
            "namespace" => "Performance",
            "path" => __DIR__ . "/../../src/Performance/Infrastructure/Database/mappings",
        ],
    ]
];