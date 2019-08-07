<?php


namespace SoftUniBlogBundle\Service\Types;


use SoftUniBlogBundle\Entity\Types;

interface TypeServiceInterface
{
    public function findOneById(int $id):?Types;
    public function findAll();

}