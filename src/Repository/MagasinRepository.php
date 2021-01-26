<?php

namespace App\Repository;

use App\Entity\Magasin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class MagasinRepository
 * @package App\Repository
 */

 class MagasinRepository extends ServiceEntityRepository{
    public function __construct(ManagerRegistry $registry){
       parent::__construct($registry, Magasin::class);
    }
 }