<?php

namespace Proletariat\Support\Cache;

use Proletariat\Support\Cache\iCache;

class FileCache implements ICache
{
    private $configCache;
    private $cacheDir;

    public function __construct()
    {
        $this->configCache = require __DIR__ . '/../../../config/cache.php';
        
        $this->cacheDir = __DIR__ . '/../../../' . $this->configCache['file']['path'];

        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function set($key, $value, $expiration = null) 
    {
        $cacheFile = $this->getCacheFilePath($key);

        $expiration = isset($expiration) ? $expiration : $this->configCache['file']['expire'];

        $data = [
            'value' => $value,
            'expiration' => time() + $expiration,
        ];

        file_put_contents($cacheFile, serialize($data));
    }

    public function get($key) 
    {
        $cacheFile = $this->getCacheFilePath($key);

        if (file_exists($cacheFile)) {
            $data = unserialize(file_get_contents($cacheFile));

            if ($data['expiration'] > time()) {
                return $data['value'];
            } else {
                unlink($cacheFile);
            }
        }

        return null;
    }

    public function delete($key) 
    {
        $cacheFile = $this->getCacheFilePath($key);

        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
    }

    public function exists($key)
    {
        $cacheFile = $this->getCacheFilePath($key);
        return file_exists($cacheFile);
    }

    private function getCacheFilePath($key) 
    {
        $key = sha1($key);
        return $this->cacheDir . $key . '.cache';
    }
}
