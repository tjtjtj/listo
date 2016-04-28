<?php

namespace Listo\Handlers;

/**
 * PutHandler.
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class PutHandler
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
        $logger->info("PUT ".$request->getRequestUri());

        $path = urldecode($request->getPathInfo());
        $elems = explode('/', ltrim($path, '/'),  2);
        if (empty($elems[1])) {
            $bucketname = $elems[0];
            return $this->app['createbucket']->exec($bucketname);

        } else {
            $bucketname = $elems[0];
            $filepath = '/'.$elems[1];
            $stream = $request->getContent(true);

            return $this->app['putobject']->exec($bucketname, $filepath, $stream);
        }
    }
}
