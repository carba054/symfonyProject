<?php


namespace SoftUniBlogBundle\Service\Reports;


use SoftUniBlogBundle\Entity\Reports;

interface ReportServiceInterface
{
    public function findOneById(int $id):?Reports;
    public function findAllByAttackerId($attackerId):?array ;
    public function findAllByDefenderId($defenderId):?array ;
    public function save($report):bool;
    public function findAll($id);
}