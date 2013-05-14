#!/usr/bin/env php
<?php
require_once __DIR__.'/vendor/autoload.php';

$app = new \Cilex\Application('Cilex');
$app->command(new \IMDb\Command\FetchCommand());
$app->register(new \Cilex\Provider\MonologServiceProvider());
$app->run();
