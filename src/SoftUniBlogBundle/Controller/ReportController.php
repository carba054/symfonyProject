<?php


namespace SoftUniBlogBundle\Controller;


use SoftUniBlogBundle\Service\Heroes\HeroServiceInterface;
use SoftUniBlogBundle\Service\Magics\MagicServiceInterface;
use SoftUniBlogBundle\Service\Reports\ReportServiceInterface;
use SoftUniBlogBundle\Service\Types\TypeServiceInterface;
use SoftUniBlogBundle\Service\Users\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SoftUniBlogBundle\Entity\Hero;
use SoftUniBlogBundle\Entity\Reports;
use Symfony\Component\Routing\Annotation\Route;
use SoftUniBlogBundle\Entity\User;



class ReportController extends Controller
{

    private $userService;
    private $heroService;
    private $typeService;
    private $magicService;
    private $reportService;

    public function __construct(ReportServiceInterface $reportService, HeroServiceInterface $heroService, TypeServiceInterface $typeService, MagicServiceInterface $magicService, UserServiceInterface $userService)
    {
        $this->heroService = $heroService;
        $this->typeService = $typeService;
        $this->magicService = $magicService;
        $this->userService = $userService;
        $this->reportService = $reportService;

    }

    /**
     * @Route("/report", name="hero_attack")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function heroAttack()
    {
        $defenderId = 0;
        foreach ($_POST as $key => $item) {
            $defenderId = $key;

        }
        /**
         * @var Hero $defender
         */
        $defender = $this->heroService->findOneById($defenderId);
        /**
         * @var Hero $attacker
         */
        $attacker = $this->heroService->findOneById($this->getUser()->getHero()->getId());
        if($defender == null || $attacker == null){
            $this->addFlash('warning', 'There is no such hero');
            return $this->redirectToRoute("blog_index");
        }elseif ($attacker->getId() == $defender->getId()){
            $this->addFlash('warning', 'Cannot attack yourself');
            return $this->redirectToRoute("blog_index");
        }elseif($defender->getCurrentHealth() == 0){
            $this->addFlash('warning', 'This character is still recovering');
            return $this->redirectToRoute("blog_index");
        }elseif($attacker->getCurrentHealth() == 0){
            $this->addFlash('warning', 'You need rest, your health is 0');
            return $this->redirectToRoute("blog_index");
        }



        $report = $this->attackProcess($attacker,$defender);


        if ($report != null){

            return $this->redirectToRoute("report", ['id' => $report->getId()]);
            //return $this->render('reports/report.html.twig', ['report'=>$report,'winner' => $win,'attacker'=> $attacker,'defender' => $defender]);

        }else{
            $this->addFlash('warning', 'The attack didn\'t happen');
            return $this->redirectToRoute("blog_index");
        }

    }


    public function attackProcess(Hero $attacker,Hero $defender)
    {
        $reports = [];
        $attackerDmg = $attacker->getDmg();
        $attackerArmor = $attacker->getArmor();
        $attackerHealth = $attacker->getCurrentHealth();
        $attackerMiss = $attacker->getMiss();
        //$attackerDisarm = $attacker->getDisarm();
        $attackerMoney = $attacker->getMoney();

        $defenderDmg = $defender->getDmg();
        $defenderArmor = $defender->getArmor();
        $defenderHealth = $defender->getCurrentHealth();
        $defenderMiss = $defender->getMiss();
        //$defenderDisarm = $defender->getDisarm();
        $defenderMoney = $defender->getMoney();


        $attackerCurrentArmor = $attackerArmor;
        $attackerCurrentHealth = $attackerHealth;

        $defenderCurrentArmor = $defenderArmor;
        $defenderCurrentHealth = $defenderHealth;
        $winner = null;
        $loser = null;
        $roundReport = '';
        for ($i = 1; $i<= 7; $i++){

            if ($i%2 == 0){
                if ($attackerCurrentArmor >0){
                    $attackerCurrentArmor -= $defenderDmg;
                    if ($attackerCurrentArmor < 0){
                        $attackerCurrentHealth -= abs($attackerCurrentArmor);
                        if ($attackerCurrentHealth < 0){
                            $attackerCurrentHealth =0;
                            $winner = $defender->getId();
                            $loser = $attacker->getId();
                            $roundReport = "The attacker take $defenderDmg DMG and left with 0 armor and 0 health";

                        }else{
                            $roundReport = "The attacker take $defenderDmg DMG and left with 0 armor and $attackerCurrentHealth health";
                        }

                    }else{
                        $roundReport = "The attacker take $defenderDmg DMG and left with $attackerCurrentArmor armor ";
                    }
                }else{
                    $attackerCurrentHealth -= $defenderDmg;
                    if ($attackerCurrentHealth <=0){
                        $attackerCurrentHealth = 0;
                        $roundReport = "The attacker lose the battle";
                        $winner = $defender->getId();
                        $loser = $attacker->getId();

                    }else{
                        $roundReport = "The attacker take $defenderDmg DMG and left with 0 armor and $attackerCurrentHealth health";
                    }
                }

            }else{
                if ($defenderCurrentArmor >0){
                    $defenderCurrentArmor -= $attackerDmg;
                    if ($defenderCurrentArmor < 0){
                        $defenderCurrentHealth -= abs($defenderCurrentArmor);
                        if ($defenderCurrentHealth < 0){
                            $defenderCurrentHealth =0;
                            $winner = $attacker->getId();
                            $loser =$defender->getId();
                            $roundReport = "The defender take $attackerDmg DMG and left with 0 armor and 0 health";

                        }else{
                            $roundReport = "The defender take $attackerDmg DMG and left with 0 armor and $defenderCurrentHealth health";
                        }

                    }else{
                        $roundReport = "The defender take $attackerDmg DMG and left with $defenderCurrentArmor armor ";
                    }
                }else{
                    $defenderCurrentHealth -= $attackerDmg;
                    if ($defenderCurrentHealth <=0){
                        $defenderCurrentHealth = 0;
                        $roundReport = "The defender lose the battle";
                        $winner = $attacker->getId();
                        $loser = $defender->getId();

                    }else{
                        $roundReport = "The defender take $attackerDmg DMG and left with 0 armor and $defenderCurrentHealth health";
                    }
                }
            }
            $reports['round'.$i] = $roundReport;
            $roundReport = null;
            if ($attackerCurrentHealth <=0 || $defenderCurrentHealth <=0){
                break;
            }
        }


        $reports['attackerId'] = $attacker;
        $reports['defenderId'] = $defender;
        $reports['winner'] = $winner;

        $report = new Reports($reports);

        $report->setWinner($winner);
        if ($this->reportService->save($report)){

            $attacker->setCurrentHealth($attackerCurrentHealth);
            $defender->setCurrentHealth($defenderCurrentHealth);

            if ($winner != null){
                $updateWins = $this->heroService->findOneById($winner);
                $updateWins->setWins($updateWins->getWins()+1);

                $updatelosses = $this->heroService->findOneById($loser);
                $updatelosses->setLosses($updatelosses->getLosses()+1);
            }else{
                $updateDraws = $this->heroService->findOneById($attacker->getId());
                $updateDraws->setDraws($updateDraws->getDraws()+1);

                $updateDraws = $this->heroService->findOneById($defender->getId());
                $updateDraws->setDraws($updateDraws->getDraws()+1);
            }
            $this->heroService->updateFight($attacker);
            $this->heroService->updateFight($defender);

            return $report;

        };


        return null;
    }

    /**
     * @Route("/reports", name="all_reports")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allMyReports()
    {


        /**
         * @var Hero $hero
         */
        $hero = $this->userService->currentUser()->getHero();

        $reports = $this->reportService->findAll($hero->getId());


        return $this->render('reports/all_reports.html.twig', ['reports'=>$reports]);

    }



    /**
     * @Route("/report{id}", name="report")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function currentReport($id)
    {


        /**
         * @var Hero $hero
         */
        $hero = $this->userService->currentUser()->getHero();

        $report = $this->reportService->findOneById($id);

        if ($report != null && ($report->getAttackerId()->getId() == $hero->getId() || $report->getDefenderId()->getId() == $hero->getId())){
            return $this->render('reports/report.html.twig', ['report'=>$report]);
        }else{
            $this->addFlash('warning', 'You don\'t have such report');
            return $this->redirectToRoute("blog_index");
        }





    }

}