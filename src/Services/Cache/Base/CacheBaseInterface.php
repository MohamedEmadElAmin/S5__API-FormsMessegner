<?php


namespace App\Services\Cache\Base;

interface CacheBaseInterface
{
    public function getFromCache(string $key);
}