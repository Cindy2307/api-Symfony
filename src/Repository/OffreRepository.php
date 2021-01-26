<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class OffreRepository
 * @package App\Repository
 */

 class OffreRepository extends ServiceEntityRepository{
    public function __construct(ManagerRegistry $registry){
       parent::__construct($registry, Offre::class);
    }
 }