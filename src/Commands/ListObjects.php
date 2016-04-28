<?php

namespace Listo\Commands;

/**
 * ListObjects
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class ListObjects extends Command
{
    public function exec($bucketname, $filepath)
    {
        $this->logger->info("cmd:ListObjects bucketname:{$bucketname} filepath:{$filepath}");

        $bucket = $this->server->getBucket($bucketname);
        if (!$bucket) {
            return $this->responseXml($this->xml->noSuchBucket($bucketname), 404);
        }
        $contents = $this->server->listObjects($bucket, $filepath);
        return $this->responseXml($this->xml->objects($bucket, $contents), 200);
    }
}