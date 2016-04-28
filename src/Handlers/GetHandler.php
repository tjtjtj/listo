<?php

namespace Listo\Handlers;

/**
 * GetHandler.
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class GetHandler
{
    protected $app;
    
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function exec()
    {
        $request = $this->app['request'];
        $logger  = $this->app['logger'];
        $logger->addInfo("GET ".$request->getRequestUri());

        $path = urldecode($request->getPathInfo());
        $queryparams = $request->query;
        $prefix    = $queryparams->get('prefix');
        $maxkeys   = $queryparams->get('max-keys');
        $delimiter = $queryparams->get('delimiter');

        $cmd = null;
        if ($path === "/") {
            return $this->app['listbuckets']->exec();
        }

        if ($queryparams->has('prefix')) {
            $bucketname = trim($path, '/');
            $filepath   = '/'.$queryparams->get('prefix');
            return $this->app['listobjects']->exec($bucketname, $filepath);
        } 

        if ($queryparams->has('acl')) {
            $elems = explode('/', ltrim($path, '/'),  2);
            $bucketname = $elems[0];
            $filepath = '/'.$elems[1];

            return $this->app['getobjectacl']->exec($bucketname, $filepath);
        }
        
        $elems = explode('/', ltrim($path, '/'),  2);
        if (count($elems) === 1) {
            $bucketname = $elems[0];
            $filepath = '/';
        }
        if (count($elems) === 2) {
            $bucketname = $elems[0];
            $filepath = '/'.$elems[1];
        }
        return $this->app['getobject']->exec($bucketname, $filepath);
    }
}
