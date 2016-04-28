<?php

namespace Listo\Commands;

/**
 * DeleteBucket
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class DeleteBucket extends Command
{
    public function exec($bucketname)
    {
        $this->logger->info("cmd:DeleteBucket bucketname:{$bucketname}");

        $bucket = $this->server->getBucket($bucketname);
        if (!$bucket) {
            return $this->responseXml($this->xml->noSuchBucket($bucketname), 404);
        }
        $this->server->deleteBucket($bucket);
        return $this->responseXml('', 204);
    }
}
