<?php


namespace SoftUniBlogBundle\Service\Heroes;


use SoftUniBlogBundle\Entity\Hero;
use SoftUniBlogBundle\Entity\Reports;
use SoftUniBlogBundle\Entity\Types;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Repository\HeroRepository;
use SoftUniBlogBundle\Service\Reports\ReportServiceInterface;
use SoftUniBlogBundle\Service\Types\TypeServiceInterface;
use SoftUniBlogBundle\Service\Users\UserServiceInterface;
use Symfony\Component\Security\Core\Security;

class HeroService implements HeroServiceInterface
{
    private $typeService;
    private $userService;
    private $heroRepository;
    private $security;
    private $reportService;
    public function __construct(TypeServiceInterface $typeService,
                                UserServiceInterface $userService,
                                Security $security,
                                ReportServiceInterface $reportService,
                                HeroRepository $heroRepository)
    {
        $this->heroRepository = $heroRepository;
        $this->userService = $userService;
        $this->typeService = $typeService;
        $this->security = $security;
        $this->reportService = $reportService;
    }


    public function create(Hero $hero): bool
    {

        /**
         * @var User $user
         */
        $user = $this->userService->currentUser();
        $user->setHero($hero);
        $hero->setOwnerId($user);
        $hero->setViewCount(0);

        return $this->heroRepository->insert($hero);

    }

    public function edit(Hero $hero, $arrRequest): bool
    {
        $hero->setStrength($arrRequest['hero']['str']);
        $hero->setAgility($arrRequest['hero']['agl']);
        $hero->setIntelligence($arrRequest['hero']['int']);
        $hero->setLuck($arrRequest['hero']['luck']);
        $hero->setMoney($arrRequest['hero']['money']);
        return $this->heroRepository->insert($hero);
    }

    public function updateFight(Hero $hero):bool
    {

        return $this->heroRepository->insert($hero);
    }

    public function delete(Hero $hero): bool
    {

        /**
         * @var User $user
         */
        $user = $this->userService->findOneById($hero->getOwnerId()->getId());

        return $this->heroRepository->delete($hero,$user);

    }

    /**
     * @param int $id
     * @return Hero|null|object
     */
    public function findOneById(int $id): ?Hero
    {
        return $this->heroRepository->find($id);
    }


    public function findReportsByAttackerId(int $id): ?array
    {

        return $this->reportService->findAllByAttackerId($id);
    }

    public function findReportsByDefenderId(int $id): ?array
    {
        return $this->reportService->findAllByDefenderId($id);
    }
}