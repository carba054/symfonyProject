<?php

namespace SoftUniBlogBundle\Repository;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use SoftUniBlogBundle\Entity\Reports;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\OptimisticLockException;


/**
 * reportsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReportRepository extends \Doctrine\ORM\EntityRepository
{

    public function __construct(EntityManagerInterface $em,
                                Mapping\ClassMetadata $metaData = null)
    {
        parent::__construct($em,
            $metaData === null ?
                new Mapping\ClassMetadata(Reports::class) :
                $metaData
        );
    }
    public function insert(Reports $reports){


        try {
            $this->_em->persist($reports);

            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {

            return false;
        }

    }

    public function findAllMyReports($id)
    {


        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = null;
        try {
            $statement = $connection->prepare("SELECT r.*,h.name as attackerName,hr.name as defenderName FROM reports as r
                                                         INNER JOIN heroes as h on r.attackerId = h.id
                                                         INNER JOIN heroes as hr on r.defenderId = hr.id
                                                         WHERE r.attackerId = :id OR r.defenderId =:id 
                                                         ORDER BY r.date DESC");
        } catch (DBALException $e) {
        }
        $statement->bindValue('id', $id);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;


    }

}
