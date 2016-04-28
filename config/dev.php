<?php

use Silex\Provider\MonologServiceProvider;

// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;

$app->register(new MonologServiceProvider(), array(
    'monolog.name' => 'listo',
    'monolog.logfile' => __DIR__.'/../var/logs/listo_dev.log',
));
