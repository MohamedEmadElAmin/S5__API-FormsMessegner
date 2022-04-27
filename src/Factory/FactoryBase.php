<?php


namespace App\Factory;


use Doctrine\ORM\EntityManagerInterface;

interface FactoryBase
{
    public static function create($entity, array $params = []);
}