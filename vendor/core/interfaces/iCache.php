<?php

namespace Proletariat\Interfaces;

interface iCache
{
    public function set($key, $value, $expiration = null);
    public function get($key);
    public function delete($key);
}