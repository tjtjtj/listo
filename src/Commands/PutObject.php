<?php

namespace Listo\Commands;

/**
 * ListObjects
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class PutObject extends Command
{
    public function exec($bucketname, $filepath, $stream)
    {
        $this->logger->info("cmd:PutObject bucketname:{$bucketname} filepath:{$filepath}");

        $bucket = $this->server->getBucket($bucketname);
        if (!$bucket) {
            return $this->responseXml($this->xml->noSuchBucket($bucketname), 404);
        }
        $this->server->putObjectStream($bucket, $filepath, $stream);
        return $this->responseXml('', 200);
    }
}
