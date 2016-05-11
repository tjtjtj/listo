<?php

namespace Listo\Flysystem;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;

class LocalMd5Plugin implements PluginInterface
{
    protected $filesystem;

    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getMethod()
    {
        return 'getMd5';
    }

    public function handle($path = null)
    {
        $adapter = $this->filesystem->getAdapter();
        return md5_file($adapter->applyPathPrefix($path));
    }
}

