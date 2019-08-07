<?php

namespace SoftUniBlogBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\OptimisticLockException;
use SoftUniBlogBundle\Entity\Hero;
use SoftUniBlogBundle\Entity\User;

/**
 * HeroRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HeroRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $metadata = null)
    {
        parent::__construct($em,
            $metadata === null?
                new Mapping\ClassMetadata(Hero::class):
                $metadata
        );
    }

    public function insert(Hero $hero){


        try {
            $this->_em->persist($hero);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        }

    }

    public function delete(Hero $hero, User $user){


        try {

            $this->_em->remove($hero);
            $user->setHero(null);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        }

    }


}