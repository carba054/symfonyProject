<?php


namespace SoftUniBlogBundle\Service\Heroes;


use SoftUniBlogBundle\Entity\Hero;

interface HeroServiceInterface
{

    public function findAllDamagedHeroes();
    public function findAll();
    public function create(Hero $hero):bool ;
    public function edit(Hero $hero, $arrRequest=null):bool ;
    public function delete(Hero $hero):bool ;
    public function findOneById(int $id):?Hero;
    public function updateFight(Hero $hero):bool ;
    public function findReportsByAttackerId(int $id):?array;
    public function findReportsByDefenderId(int $id):?array;
}