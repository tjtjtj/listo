<?php

namespace Listo\Commands;

/**
 * DeleteObject
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class DeleteObject extends Command
{
    public function exec($bucketname, $filepath)
    {
        $this->logger->info("cmd:DeleteObject bucketname:{$bucketname} filepath:{$filepath}");

        $bucket = $this->server->getBucket($bucketname);
        if (!$bucket) {
            return $this->responseXml($this->xml->noSuchBucket($bucketname), 404);
        }
        $this->server->deleteObject($bucket, $filepath);
        return $this->responseXml('', 204);
    }
}
