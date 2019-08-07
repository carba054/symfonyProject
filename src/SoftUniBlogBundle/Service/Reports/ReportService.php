<?php


namespace SoftUniBlogBundle\Service\Reports;


use SoftUniBlogBundle\Entity\Hero;
use SoftUniBlogBundle\Entity\Reports;
use SoftUniBlogBundle\Repository\ReportRepository;


class ReportService implements ReportServiceInterface
{
    private $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * @param int $id
     * @return Reports|null|object
     */
    public function findOneById(int $id): ?Reports
    {
        return $this->reportRepository->find($id);
    }



    /**
     * @return null|Reports|object|array
     */
    public function findAllByAttackerId($id): ?array
    {
        /**
         * @var Reports $item
         */
        $test = $this->reportRepository->findBy(['attackerId'=> $id]);
        $reports = [];
        foreach ($test as $item) {
            $reports[] = $item;

        }

        return $reports;
    }
    /**
     * @return null|Reports|object|array
     */
    public function findAllByDefenderId($id): ?array
    {
        /**
         * @var Reports $item
         */
        $test = $this->reportRepository->findBy(['attackerId'=> $id]);
        $reports = [];
        foreach ($test as $item) {
            $reports[] = $item;

        }

        return $reports;
    }

    public function save($report): bool
    {
        return $this->reportRepository->insert($report);
    }

    public function findAll($id)
    {
       return $this->reportRepository->findAllMyReports($id);
    }
}