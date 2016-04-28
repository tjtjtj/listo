<?php

namespace Listo\Commands;

/**
 * GetObject
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class GetObject extends Command
{
    public function exec($bucketname, $filepath)
    {
        $this->logger->info("cmd:GetObject bucketname:{$bucketname} filepath:{$filepath}");

        $bucket = $this->server->getBucket($bucketname);
        if (!$bucket) {
            return $this->responseXml($this->xml->noSuchBucket($bucketname), 404);
        }
        if (!$this->server->existsObject($bucket, $filepath)) {
            return $this->responseXml($this->xml->noSuchKey($filepath), 404);
        }
        $stream = $this->server->getObjectStream($bucket, $filepath);
        return $this->responseStream(function() use($stream) {
            echo stream_get_contents($stream);
        });
    }
}
