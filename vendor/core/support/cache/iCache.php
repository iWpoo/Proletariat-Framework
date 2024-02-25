<?php

namespace Proletariat\Support\Cache;

interface iCache
{
    public function set($key, $value, $expiration = null);
    public function get($key);
    public function delete($key);
}