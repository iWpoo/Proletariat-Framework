<?php

namespace Commands;

class RouteCache
{
    public function handle()
    {
        echo "Clearing the cache...\n";
        if ($this->clearCache()) {
            echo 'Cache cleared successfully.';
            exit();
        }
        echo 'Clearing cache failed.';
    }

    private function clearCache()
    {
        $cacheFile = __DIR__ . '/../../storage/cache/routes.cache';;
        if (file_exists($cacheFile)) {
            if (unlink($cacheFile)) {
                return true;
            }
            return false;
        }
        return true;
    }
}
 
(new RouteCache)->handle();