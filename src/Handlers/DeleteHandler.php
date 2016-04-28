<?php

namespace Listo\Handlers;

/**
 * DeleteHandler.
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class DeleteHandler
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    function exec()
    {
        $request = $this->app['request'];
        $logger  = $this->app['logger'];
        $logger->info("DELETE ".$request->getRequestUri());

        $path = urldecode($request->getPathInfo());
        $elems = explode('/', ltrim($path, '/'),  2);
        $bucketname = $elems[0];
        $filepath = '/'.$elems[1];

        return $this->app['deleteobject']->exec($bucketname, $filepath);
    }
}
