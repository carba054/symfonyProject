<?php


namespace SoftUniBlogBundle\Service\Magics;


use SoftUniBlogBundle\Entity\Magics;

interface MagicServiceInterface
{
    public function findOneById(int $id):?Magics;
    public function findAll();
    public function findUnusedMagics($heroId);
    public function save($magic);
}