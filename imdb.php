#!/usr/bin/env php
<?php
require_once __DIR__.'/vendor/autoload.php';

$app = new \Cilex\Application('Cilex');

$app->register(new \Cilex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/imdb.log',
));
$app->register(new \Cilex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/imdb.db',
    ),
));

$app['lists'] = $app->share(function () {
    return array(
        'MVUwZ28TV6A',
        'QLMympQqnY0',
        'rMi115T_dNw',
    );
});

$app->command(new \IMDb\Command\FetchCommand('imdb:fetch', $app));

$app->run();
