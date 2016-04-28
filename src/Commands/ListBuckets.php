<?php

namespace Listo\Commands;

use Symfony\Component\HttpFoundation\Response;

/**
 * ListBuckets
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class ListBuckets extends Command
{
    public function exec()
    {
        $this->logger->info("cmd:ListBuckets");

        $buckets = $this->server->listBuckets();
        return new Response($this->xml->buckets($buckets), 200);
    }
}
