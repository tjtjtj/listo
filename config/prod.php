<?php

// configure your app for the production environment
use Silex\Provider\MonologServiceProvider;

$app['debug'] = false;

$app->register(new MonologServiceProvider(), array(
    'monolog.name' => 'listo',
    'monolog.logfile' => __DIR__.'/../var/logs/listo.log',
));

$app['listo.config'] = [
    'owner' => [
        'ID' => 1234,
        'DisplayName' => 'ownername'
    ],
    //
    'buckets' => [
        'path' => __DIR__ . '/../buckets/',
    ],
    'fs' => [
        'buckets_path' => __DIR__ . '/../buckets/',
    ],
    'fakeauth' => [
        'acceskey'        => getenv('V2_ACCESSKEY'),
        'secretaccesskey' => getenv('V2_SECRETACCESSKEY'),
    ],
];
