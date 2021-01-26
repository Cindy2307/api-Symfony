<?php

namespace App\Repository;

use App\Entity\Partenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PartenaireRepository
 * @package App\Repository
 */

 class PartenaireRepository extends ServiceEntityRepository{
    public function __construct(ManagerRegistry $registry){
       parent::__construct($registry, Partenaire::class);
    }
 }