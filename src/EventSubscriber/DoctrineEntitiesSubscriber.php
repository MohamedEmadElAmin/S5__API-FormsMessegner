<?php


namespace App\EventSubscriber;

use App\Entity\ShippingOrder\ShippingOrder;
use App\Entity\ShippingOrder\ShippingOrderIssue;
use App\Entity\ShippingOrder\ShippingOrderItem;
use App\Factory\Log\AuditShippingOrderFactory;
use App\Factory\Log\AuditShippingOrderIssueFactory;
use App\Factory\Log\AuditShippingOrderItemFactory;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class DoctrineEntitiesSubscriber implements EventSubscriberInterface
{
    protected EntityManagerInterface $em;
    function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('persist', $args);
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->logActivity('remove', $args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->logActivity('update', $args);
    }


    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof ShippingOrder && !$entity instanceof ShippingOrderIssue && !$entity instanceof ShippingOrderItem) {
            return;
        }

        $auditEntity = NULL;
        if($entity instanceof ShippingOrder) {
            $auditEntity = AuditShippingOrderFactory::create($entity);
        }
        if($entity instanceof ShippingOrderIssue) {
            $auditEntity = AuditShippingOrderIssueFactory::create($entity);
        }
        if($entity instanceof ShippingOrderItem) {
            $auditEntity = AuditShippingOrderItemFactory::create($entity);
        }

        $auditEntity->setAction($action);
        $this->em->persist($auditEntity);
        $this->em->flush();
    }
}
