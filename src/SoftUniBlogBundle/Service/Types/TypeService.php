<?php


namespace SoftUniBlogBundle\Service\Types;


use SoftUniBlogBundle\Entity\Types;
use SoftUniBlogBundle\Repository\TypesRepository;

class TypeService implements TypeServiceInterface
{
    private $typeRepository;

    public function __construct(TypesRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }


    public function findAll()
    {
        return $this->typeRepository->findAll();
    }

    /**
     * @param int $id
     * @return Types|null|object
     */
    public function findOneById(int $id): ?Types
    {


        return $this->typeRepository->find($id);

    }
}