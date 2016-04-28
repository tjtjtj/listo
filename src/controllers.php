<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

// BEFORE
$app->before(function (Request $request) use ($app) {
    if ($app['debug']) return;
    $result = $app['authorize']->auth($request);
    if ($result === false) {
        return new Response('Forbidden', 403);
    }
});
// GET
$app->get('/{path}', function ($path) use ($app) {
    return $app['gethandler']->exec();
})->assert('path','.*');
// PUT
$app->put('/{path}', function ($path) use ($app) {
    return $app['puthandler']->exec();
})->assert('path','.*');
// DELETE
$app->delete('/{path}', function ($path) use ($app) {
    return $app['deletehandler']->exec();
})->assert('path','.*');

$app->error(function (\Exception $e, $code) use ($app) {
    $app['logger']->info("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");

    if ($app['debug']) {
        return;
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
