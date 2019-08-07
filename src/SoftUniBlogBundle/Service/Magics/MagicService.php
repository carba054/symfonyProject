<?php


namespace SoftUniBlogBundle\Service\Magics;


use SoftUniBlogBundle\Entity\Magics;
use SoftUniBlogBundle\Repository\MagicsRepository;

class MagicService implements MagicServiceInterface
{

    private $magicRepository;

    public function __construct(MagicsRepository $magicRepository)
    {
        $this->magicRepository = $magicRepository;
    }

    /**
     * @param int $id
     * @return Magics|null|object
     */
    public function findOneById(int $id):?Magics
    {
        return $this->magicRepository->find($id);
    }

    public function findAll()
    {
        return $this->magicRepository->findAll();
    }
}