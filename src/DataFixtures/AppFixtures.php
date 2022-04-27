<?php

namespace App\DataFixtures;

use App\Entity\ShippingOrder\OrderStatus;
use App\Entity\ShippingOrder\Product;
use App\Entity\Utilities\Issue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 5 products!
        for ($i = 0; $i < 5; $i++) {
            $product = new Product();
            $product->setName('product '.$i);
            $manager->persist($product);
        }

        $status = new OrderStatus();
        $status->setName('ORDER_RECEIVED');
        $manager->persist($status);
        $status = new OrderStatus();
        $status->setName('ORDER_CANCELED');
        $manager->persist($status);
        $status = new OrderStatus();
        $status->setName('ORDER_PROCESSING');
        $manager->persist($status);
        $status = new OrderStatus();
        $status->setName('ORDER_READY_TO_SHIP');
        $manager->persist($status);
        $status = new OrderStatus();
        $status->setName('ORDER_SHIPPED');
        $manager->persist($status);


        $issue = new Issue();
        $issue->setName('item missing');
        $manager->persist($issue);
        $issue = new Issue();
        $issue->setName('item damaged');
        $manager->persist($issue);
        $issue = new Issue();
        $issue->setName('item mismatched');
        $manager->persist($issue);


        $manager->flush();
    }
}
