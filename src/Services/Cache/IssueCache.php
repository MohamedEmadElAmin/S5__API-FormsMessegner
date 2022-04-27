<?php


namespace App\Services\Cache;

use App\Entity\Utilities\Issue;
use App\Services\Cache\Base\CacheBase;
use App\Services\Cache\Base\CacheBaseInterface;
use Symfony\Contracts\Cache\ItemInterface;

class IssueCache extends CacheBase implements CacheBaseInterface
{
    public function getFromCache(string $key): ?Issue
    {
        //since there is no back end for status, no need to invalidate the cache in doctrine event
        $issues = $this->cache->get('Issues', function (ItemInterface $item)
        {
            $item->expiresAfter(3600); //seconds
            $item->tag(['Issues']); //for now we use key as tag
            return $this->em->getRepository(Issue::class)->findAll();
        });

        foreach ($issues as $currentIssue) {
            if ($currentIssue->getId() == $key){
                //getReference is generated by the cache
                return $this->em->getReference(Issue::class, $currentIssue->getId());
            }
        }
        return NULL;
    }
}