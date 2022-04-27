<?php


namespace App\Services\Cache\Base;


use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class CacheBase
{
    protected TagAwareCacheInterface $cache;
    protected ObjectManager $em;

    public function __construct(TagAwareCacheInterface $cache, ManagerRegistry $doctrine)
    {
        $this->cache = $cache;
        $this->em = $doctrine->getManager();
    }
}