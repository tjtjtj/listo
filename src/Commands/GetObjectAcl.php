<?php

namespace Listo\Commands;

/**
 * GetObjectAcl
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class GetObjectAcl extends Command
{
    public function exec($bucketname, $filepath)
    {
        $this->logger->info("cmd:GetObjectAcl bucketname:{$bucketname} filepath:{$filepath}");

        return $this->responseXml("", 200);
    }
}
