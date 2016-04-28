<?php

namespace Listo;

/**
 * Bucket.
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class Bucket
{
    public $name;
    public $createdAt;

    public function __construct($name, $createdAt)
    {
        $this->name = $name;
        if (is_numeric($createdAt)) {
            $this->createdAt = \Carbon\Carbon::createFromTimestamp($createdAt);
        }
    }

    public function toArray()
    {
        return [
            'Name' => $this->name,
            'CreationDate'=> $this->createdAt->toIso8601String(),
        ];
    }
}
