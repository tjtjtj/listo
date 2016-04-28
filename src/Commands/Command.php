<?php

namespace Listo\Commands;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Command
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class Command
{
    public $server;
    public $xml;
    public $logger;

    function responseXml($body, $status = 200)
    {
        return new Response($body, $status, ['Content-Type' => 'application/xml']);
    }

    function responseStream(callable $callback = null, $status = 200)
    {
        return new StreamedResponse($callback, $status);
    }
}
