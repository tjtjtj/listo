<?php

namespace Listo\Commands;

/**
 * CreateBucket
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class CreateBucket extends Command
{
    public function exec($bucketname)
    {
        $this->logger->info("cmd:CreateBucket bucketname:{$bucketname}");

        $bucket = $this->server->createBucket($bucketname);
        if (!$bucket) {
            return $this->responseXml($this->xml->noSuchBucket($bucketname), 404);
        }
        return $this->responseXml('', 200);
    }
}
