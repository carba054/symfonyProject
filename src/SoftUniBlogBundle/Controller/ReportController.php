<?php


namespace SoftUniBlogBundle\Controller;


use SoftUniBlogBundle\Entity\Magics;
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

    public function chanceForMagic(Hero $hero, $type)
    {
        if ($hero->getMagics() != null) {
            foreach ($hero->getMagics() as $magicId) {
                /**
                 * @var Magics $magic
                 */
                $magic = $this->magicService->findOneById($magicId);
                $typeMagic = $magic->getType();
                $percentChance = $magic->getPercentChance();

                $chance = rand(0, 100);
                if ($percentChance >= $chance && $typeMagic == $type) {
                    return $magic;
                }
            }
        }
        return null;
    }


    public function attackProcess(Hero $attacker,Hero $defender)
    {
        $reports = [];

        $attackerArmor = $attacker->getArmor();
        $attackerHealth = $attacker->getCurrentHealth();
        $defenderArmor = $defender->getArmor();
        $defenderHealth = $defender->getCurrentHealth();

        $winner = null;
        $loser = null;
        for ($i = 1; $i<= 7; $i++){
            $defenderDmg = $defender->getDmg();
            $attackerDmg = $attacker->getDmg();
            $attackerMiss = $attacker->getMiss();
            $defenderMiss = $defender->getMiss();
            $roundReport = '';
            if ($i%2 == 0){
                $attackerMagic = $this->chanceForMagic($attacker, 0);
                $defenderMagic = $this->chanceForMagic($defender, 1);
                if ($defenderMagic != null){
                    $defenderCrit = $defenderMagic->getCritical();
                    $roundReport .= "Defender activated magic (".$defenderMagic->getName().'). ';
                    $chance = rand(0,100);
                    if ($defenderCrit >= $chance){
                        $roundReport .= "CRITICAL! ";
                        $defenderDmg += $defenderMagic->getDmg()*2;
                    }else{
                        $defenderDmg += $defenderMagic->getDmg();
                    }
                }
                if ($attackerMagic != null){
                    $attackerMiss += $attackerMagic->getDodge();
                    if ($attackerHealth+$attackerMagic->getHeal() > $attacker->getMaxHealth()){
                        $attackerHealth = $attacker->getMaxHealth();
                    }else{
                        $attackerHealth += $attackerMagic->getHeal();

                    }

                    $attackerArmor += $attackerMagic->getArmor();
                    $roundReport .= "Attacker activated magic (".$attackerMagic->getName().'). ';
                    $chance = rand(0,100);
                    if ($attackerMiss >= $chance){
                        $roundReport .= "The defender missed! ";
                        $reports['round'.$i] = $roundReport;
                        continue;
                    }

                }
                if ($attackerArmor >0){
                    $attackerArmor -= $defenderDmg;
                    if ($attackerArmor < 0){
                        $attackerHealth -= abs($attackerArmor);
                        if ($attackerHealth < 0){
                            $attackerHealth =0;
                            $stolenMoney = $attacker->getMoney()*0.1;
                            $winner = $defender;
                            $loser = $attacker;
                            $roundReport .= "The attacker lose the battle and $stolenMoney money";
                        }else{
                            $roundReport .= "The attacker take $defenderDmg DMG and left with 0 armor and $attackerHealth health";
                        }
                    }else{
                        $roundReport .= "The attacker take $defenderDmg DMG and left with $attackerArmor armor ";
                    }
                }else{
                    $attackerHealth -= $defenderDmg;
                    if ($attackerHealth <=0){
                        $attackerHealth = 0;
                        $stolenMoney = $attacker->getMoney()*0.1;
                        $winner = $defender;
                        $loser = $attacker;
                        $roundReport .= "The attacker lose the battle and $stolenMoney money";
                    }else{
                        $roundReport .= "The attacker take $defenderDmg DMG and left with 0 armor and $attackerHealth health";
                    }
                }
            }else{
                $attackerMagic = $this->chanceForMagic($attacker, 1);
                $defenderMagic = $this->chanceForMagic($defender, 0);
                if ($attackerMagic != null){
                    $attackerCrit = $attackerMagic->getCritical();
                    $roundReport .= "Attacker activated magic (".$attackerMagic->getName().'). ';
                    $chance = rand(0,100);
                    if ($attackerCrit >= $chance){
                        $roundReport .= "CRITICAL! ";
                        $attackerDmg += $attackerMagic->getDmg()*2;
                    }else{
                        $attackerDmg += $attackerMagic->getDmg();
                    }


                }
                if ($defenderMagic != null){
                    $defenderMiss += $defenderMagic->getDodge();
                    if ($defenderHealth+$defenderMagic->getHeal() > $defender->getMaxHealth()){
                        $defenderHealth = $defender->getMaxHealth();
                    }else{
                        $defenderHealth += $defenderMagic->getHeal();
                    }
                    $defenderArmor += $defenderMagic->getArmor();
                    $chance = rand(0,100);
                    $roundReport .= "Defender activated magic (".$defenderMagic->getName()."). ";
                    if ($defenderMiss >= $chance){
                        $roundReport .= "The attacker missed! ";
                        $reports['round'.$i] = $roundReport;
                        continue;
                    }

                }
                if ($defenderArmor >0){
                    $defenderArmor -= $attackerDmg;
                    if ($defenderArmor < 0){
                        $defenderHealth -= abs($defenderArmor);
                        if ($defenderHealth < 0){
                            $defenderHealth =0;
                            $stolenMoney = $defender->getMoney()*0.1;
                            $winner = $attacker;
                            $loser =$defender;
                            $roundReport .= "The defender lose the battle and $stolenMoney money";
                        }else{
                            $roundReport .= "The defender take $attackerDmg DMG and left with 0 armor and $defenderHealth health";
                        }
                    }else{
                        $roundReport .= "The defender take $attackerDmg DMG and left with $defenderArmor armor ";
                    }
                }else{
                    $defenderHealth -= $attackerDmg;
                    if ($defenderHealth <=0){
                        $defenderHealth = 0;
                        $stolenMoney = $defender->getMoney()*0.1;
                        $winner = $attacker;
                        $loser = $defender;
                        $roundReport .= "The defender lose the battle and $stolenMoney money";
                    }else{
                        $roundReport .= "The defender take $attackerDmg DMG and left with 0 armor and $defenderHealth health";
                    }
                }
            }
            $reports['round'.$i] = $roundReport;

            if ($attackerHealth <=0 || $defenderHealth <=0){
                break;
            }
        }


        $reports['attackerId'] = $attacker;
        $reports['defenderId'] = $defender;
        $reports['winner'] = null;


        $report = new Reports($reports);

            $attacker->setCurrentHealth($attackerHealth);
            $defender->setCurrentHealth($defenderHealth);

        if ($winner != null){
            $report->setWinner($winner->getId());
            $winner->setWins($winner->getWins()+1);
            $winner->setMoney($winner->getMoney()+$stolenMoney);

            $loser->setLosses($loser->getLosses()+1);
            $loser->setExperience(2);
            $loser->setMoney($loser->getMoney()-$stolenMoney);

            $this->heroService->updateFight($winner);
            $this->heroService->updateFight($loser);
        }else{
            $attacker->setDraws($attacker->getDraws()+1);
            $attacker->setExperience(1);

            $defender->setDraws($defender->getDraws()+1);
            $defender->setExperience(1);

            $this->heroService->updateFight($attacker);
            $this->heroService->updateFight($defender);
        }

            $this->reportService->save($report);
            return $report;

        //};
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