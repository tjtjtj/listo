<?php

use Silex\Application;
//use Silex\Provider\TwigServiceProvider;
//use Silex\Provider\UrlGeneratorServiceProvider;
//use Silex\Provider\ValidatorServiceProvider;
//use Silex\Provider\ServiceControllerServiceProvider;
//use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\MonologServiceProvider;

$app = new Application();
//$app->register(new UrlGeneratorServiceProvider());
//$app->register(new ValidatorServiceProvider());
//$app->register(new ServiceControllerServiceProvider());
//$app->register(new TwigServiceProvider());
//$app->register(new HttpFragmentServiceProvider());
//$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
//    // add custom globals, filters, tags, ...
//
//    return $twig;
//}));

$app['logger'] = $app->share(function ($app) {
  return new MonologServiceProvider();
  //return new MonologServiceProvider($app);
});
// auth
$app['authorize'] = $app->share(function ($app) {
    $config = $app['listo.config']['v2auth'];
    $auth = new Listo\V2Auth($config);
    $auth->logger = $app['logger'];
    return $auth;
});
// fs
$app['fs'] = $app->share(function ($app) {
    $settings = $app['listo.config']['buckets'];
    $adapter = new League\Flysystem\Adapter\Local($settings['path']);
    $fs = new League\Flysystem\Filesystem($adapter);
    return $fs;
});
// server
$app['server'] = $app->share(function ($app) {
    $sv = new Listo\Server($app['fs']);
    $sv->logger = $app['monolog'];
    return $sv;
});
// xml
$app['xml'] = $app->share(function ($app) {
    return new Listo\XmlAdapter();
});

// handlers
$app['gethandler'] = $app->share(function ($app) {
    return new Listo\Handlers\GetHandler($app);
});
$app['puthandler'] = $app->share(function ($app) {
    return new Listo\Handlers\PutHandler($app);
});
$app['deletehandler'] = $app->share(function ($app) {
    return new Listo\Handlers\DeleteHandler($app);
});

// commands
$app['createbucket'] = $app->share(function ($app) {
    $cmd = new Listo\Commands\CreateBucket();
    $cmd->server = $app['server'];
    $cmd->xml    = $app['xml'];
    $cmd->logger = $app['logger'];
    return $cmd;
});
$app['deletebucket'] = $app->share(function ($app) {
    $cmd = new Listo\Commands\DeleteBucket();
    $cmd->server = $app['server'];
    $cmd->xml    = $app['xml'];
    $cmd->logger = $app['logger'];
    return $cmd;
});
$app['listbuckets'] = $app->share(function ($app) {
    $cmd = new Listo\Commands\ListBuckets();
    $cmd->server = $app['server'];
    $cmd->xml    = $app['xml'];
    $cmd->logger = $app['logger'];
    return $cmd;
});
$app['listobjects'] = $app->share(function ($app) {
    $cmd = new Listo\Commands\ListObjects();
    $cmd->server = $app['server'];
    $cmd->xml    = $app['xml'];
    $cmd->logger = $app['logger'];
    return $cmd;
});
$app['getobject'] = $app->share(function ($app) {
    $cmd = new Listo\Commands\GetObject();
    $cmd->server = $app['server'];
    $cmd->xml    = $app['xml'];
    $cmd->logger = $app['logger'];
    return $cmd;
});
$app['getobjectacl'] = $app->share(function ($app) {
    $cmd = new Listo\Commands\GetObjectAcl();
    $cmd->server = $app['server'];
    $cmd->xml    = $app['xml'];
    $cmd->logger = $app['logger'];
    return $cmd;
});
$app['putobject'] = $app->share(function ($app) {
    $cmd = new Listo\Commands\PutObject();
    $cmd->server = $app['server'];
    $cmd->xml    = $app['xml'];
    $cmd->logger = $app['logger'];
    return $cmd;
});
$app['deleteobject'] = $app->share(function ($app) {
    $cmd = new Listo\Commands\DeleteObject();
    $cmd->server = $app['server'];
    $cmd->xml    = $app['xml'];
    $cmd->logger = $app['logger'];
    return $cmd;
});

return $app;
