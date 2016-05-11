<?php
namespace Listo;

/**
 * Content.
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class Content
{
    public $name;
    public $updatedAt;
    public $size;
    public $etag;

    public function __construct($name, $updatedAt, $size, $etag)
    {
        $this->name = $name;
        if (is_numeric($updatedAt)) {
            $this->updatedAt = \Carbon\Carbon::createFromTimestamp($updatedAt);
        }
        $this->size = $size;
        $this->etag = $etag;
    }

    public function toArray()
    {
        return [
            'Key' => $this->name,
            'LastModified' => $this->updatedAt->toIso8601String(),
            'Size' => $this->size,
            'ETag' => $this->etag,
            'StorageClass' => 'STANDARD',
            'Owner' => [
              'ID' => 8050,
              'DisplayName' => 'buckettest00002'
            ],
        ];
    }
}
