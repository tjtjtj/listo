<?php

namespace Listo;

/**
 * Server.
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class Server
{
    public $fs;
    public $logger;

    public function __construct($fs)
    {
        $this->fs = $fs;
    }

    public function CreateBucket($name)
    {
        $this->logger->debug("CreateBucket bucket:{$name}");
        $this->fs->createDir($name);
        return $this->getBucket($name);
    }

    public function DeleteBucket($bucket)
    {
        $this->logger->debug("DeleteBucket bucket:{$bucket->name}");
        $this->fs->deleteDir($bucket->name);
        return;
    }

    public function listBuckets()
    {
        $ret = [];
        $contents = $this->fs->listContents();
        foreach ($contents as $object) {
            if ($object['type'] === 'dir') {
                $ret[] = new Bucket($object['path'], $object['timestamp']);
            }
        }
        return $ret;
    }

    public function getBucket($name)
    {
        foreach ($this->listBuckets() as $b) {
            if ($b->name === $name) {
                return $b;
            }
        }
        return null;
    }

    public function listObjects($bucket, $filepath)
    {
        $filepath = $this->normalizeFilepath($filepath);
        $this->logger->debug("listObjects bucket:{$bucket->name} filepath:{$filepath}");

        $ret = [];
        $conts = $this->fs->listContents($bucket->name . $filepath);
        foreach ($conts as $con) {

            $this->logger->debug('path: '.$con['path']);
            $this->logger->debug('type: '.$con['type']);

            $path = $con['path'];
            $path = ltrim($path, $bucket->name);
            $path = ltrim($path, '/');

            if ($con['type'] === 'file') {
                $ret[] = new Content(
                    $path,
                    $con['timestamp'],
                    $con['size'],
                    'etag'
                );
            } else {
                $ret[] = new Content(
                    $path.'/',
                    $con['timestamp'],
                    0,
                    'etag'
                );
            }
        }
        return $ret;
    }

    public function existsObject($bucket, $filepath)
    {
        $filepath = $this->normalizeFilepath($filepath);
        $this->logger->debug("existsObject bucket:{$bucket->name} filepath:{$filepath}");

        return $this->fs->has($bucket->name . $filepath);
    }

    public function getObjectStream($bucket, $filepath)
    {
        $filepath = $this->normalizeFilepath($filepath);

        $has = $this->fs->has($bucket->name . $filepath);
        if ($has) {
            return $this->fs->readStream($bucket->name . $filepath);
        }

        return false;
    }

    public function putObjectStream($bucket, $filepath, $stream)
    {
        $filepath = $this->normalizeFilepath($filepath);

        $this->logger->debug("putObjectStream bucket:{$bucket->name} filepath:{$filepath}");

        if (substr($filepath, -1) === '/') {
            $path = $bucket->name. rtrim($filepath, '/');
            $this->fs->createDir($path);
            return;
        }

        $this->fs->putStream($bucket->name . $filepath, $stream);
    }

    public function putObject($bucket, $filepath, $contents)
    {
        $filepath = $this->normalizeFilepath($filepath);
        $this->logger->debug("putObject bucket:{$bucket->name} filepath:{$filepath}");

        if (substr($filepath, -1) === '/') {
            $path = $bucket->name. rtrim($filepath, '/');
            $this->fs->createDir($path);
            return;
        }
        $this->fs->put($bucket->name . $filepath, $contents);
    }

    public function deleteObject($bucket, $filepath)
    {
        $filepath = $this->normalizeFilepath($filepath);
        $this->logger->debug("deleteObject bucket:{$bucket->name} filepath:{$filepath}");

        if (substr($filepath, -1) === '/') {
            $path = $bucket->name. rtrim($filepath, '/');
            $this->fs->deleteDir($path);
            return;
        }
        $this->fs->delete($bucket->name . $filepath);
    }

    protected function getMeta($bucket, $filepath)
    {
        return $this->fs->listContents($bucket->name . $filepath);
    }

    protected function normalizeFilepath($source)
    {
        $source = str_replace('../', '', $source);
        return str_replace('./', '', $source);
    }
}
