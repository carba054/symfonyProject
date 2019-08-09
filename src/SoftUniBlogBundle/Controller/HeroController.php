<?php

namespace SoftUniBlogBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use mysql_xdevapi\Exception;
use function PHPSTORM_META\elementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Hero;
use SoftUniBlogBundle\Entity\Magics;
use SoftUniBlogBundle\Entity\Reports;
use SoftUniBlogBundle\Entity\Types;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\HeroType;
use SoftUniBlogBundle\Repository\MagicsRepository;
use SoftUniBlogBundle\Service\Heroes\HeroService;
use SoftUniBlogBundle\Service\Heroes\HeroServiceInterface;
use SoftUniBlogBundle\Service\Magics\MagicServiceInterface;
use SoftUniBlogBundle\Service\Reports\ReportServiceInterface;
use SoftUniBlogBundle\Service\Types\TypeServiceInterface;
use SoftUniBlogBundle\Service\Users\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HeroController extends Controller
{
    private $userService;
    private $heroService;
    private $typeService;
    private $magicService;
    private $reportService;

    public function __construct(ReportServiceInterface $reportService,
                                HeroServiceInterface $heroService,
                                TypeServiceInterface $typeService,
                                MagicServiceInterface $magicService,
                                UserServiceInterface $userService)
    {
        $this->heroService = $heroService;
        $this->typeService = $typeService;
        $this->magicService = $magicService;
        $this->userService = $userService;
        $this->reportService = $reportService;

    }



    /**
     * @Route("/create", name="hero_create", methods={"GET"})
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {
        $type = $this->getDoctrine()->getRepository(Types::class);
        $magic = $this->getDoctrine()->getRepository(Magics::class);
        return $this->render('heroes/create.html.twig',
            ['form' => $this
                ->createForm(HeroType::class)
                ->createView(),
                'type'=>$type->findAll(),
                'magic'=>$magic->findAll()

            ]
            );
    }

    /**
     * @Route("/create", methods={"POST"})
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProcess(Request $request)
    {
        $hero = new Hero();
        $form = $this->createForm(HeroType::class, $hero);
        $form->handleRequest($request);
        $arrRequest = $request->request->all();
        $type =$this->typeService->findOneById($arrRequest['hero']['typeId']);
        $magic =$this->magicService->findOneById($arrRequest['hero']['magics']);
        $hero->setTypeId($type);
        $hero->setMagics($magic);
        if($this->heroService->create($hero)){
            $this->addFlash('info', 'Create hero successfully');
            return $this->redirectToRoute("blog_index");
        }else{
            $this->addFlash('warning', 'Something is wrong, try again!');
            return $this->redirectToRoute("blog_index");
        }

    }


    /**
     * @Route("hero/{id}", name="hero_view")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view($id){
        /**
         * @var Hero $hero
         */
        $hero = $this->currentHeroOrById($id);
        if (null === $hero) {
            return $this->redirectToRoute("blog_index");
        }
        $hero->setViewCount($hero->getViewCount()+1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($hero);
        $em->flush();
        $magicsId = $hero->getMagics();
        $magics =[];
        foreach ($magicsId as $magicid) {
            $magics[]= $this->magicService->findOneById($magicid);
        }
        $types = $this->typeService->findAll();
        $progress = $hero->getExperience()% 100;
        return $this->render("heroes/view.html.twig", ['hero'=>$hero,'magics'=>$magics, 'progress'=>$progress, 'types'=>$types]);
    }



    /**
     * @Route("/delete/{id}", name="hero_delete", methods={"GET"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function delete($id)
    {
        /**
         * @var Hero $hero
         */
        $hero = $this->currentHeroOrById($id);
        if (null === $hero) {
            return $this->redirectToRoute("blog_index");
        }
       if(!$this->isOwnerOrAdmin($hero)){
            return $this->redirectToRoute("blog_index");
        }
        return $this->render('heroes/delete.html.twig',
            ['hero' => $hero]);
    }

    /**
     * @Route("/delete/{id}", methods={"POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function deleteProcess($id)
    {
        /**
         * @var Hero $hero
         */
        $hero = $this->currentHeroOrById($id);
        if (isset($_POST['delete'])){
            if ($this->heroService->delete($hero)){
                $this->addFlash('success', 'Delete hero successfully');
                return $this->redirectToRoute("blog_index");
            }else{
                return $this->render('heroes/delete.html.twig',
                    ['hero' => $hero]);
            }
        }
        return $this->render('heroes/delete.html.twig',
            ['hero' => $hero]);
    }

    /**
     * @param Hero $hero
     * @return bool
     */
    private function  isOwnerOrAdmin(Hero $hero){
        /**
         * @var User $currentUser
         */
        $currentUser = $this->getUser();
        if ($currentUser->isOwner($hero) || $currentUser->isAdmin()){
            return true;
        }
        return false;
    }

    /**
     * @Route("/heroes/my_hero", name="my_hero", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showMyHero(){
        /**
         * @var Hero $hero
         */
        $hero = $this->currentHeroOrById();
        if (null === $hero) {
            return $this->redirectToRoute("blog_index");
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($hero);
        $em->flush();
        $magicsId = $hero->getMagics();
        $magics =[];
        foreach ($magicsId as $magicid) {
            $magics[]= $this->magicService->findOneById($magicid);
        }
        $types = $this->typeService->findAll();
        $progress = $hero->getExperience()% 100;




        return $this->render("heroes/my_hero.html.twig", ['hero'=>$hero , 'types' => $types, 'progress' => $progress , 'magics' =>$magics]);

    }

    /**
     * @Route("/heroes/my_hero", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function saveMyHero(Request $request){
        $arrRequest = $request->request->all();
        /**
         * @var Hero $hero
         */
        $hero = $this->currentHeroOrById();
        $stats = [];
        $stats['agl'] = $hero->getAgility();
        $stats['str'] = $hero->getStrength();
        $stats['int'] = $hero->getIntelligence();
        $stats['luck'] = $hero->getLuck();
        $stats['money'] = $hero->getMoney();
        $spend = 0;
        $error = false;
        foreach ($arrRequest['hero'] as $key => $request) {
            if (isset($stats[$key]) && is_numeric($request)){
                $currentSpend = 0;
                for ($x = $stats[$key]; $x < $request; $x++){
                    $currentSpend += $x*3;
                }
                $spend += $currentSpend;
            }else{
                $error = true;
                break;
            }
        }
        $money = $stats['money']-$spend;
        if ($money < 0 || $error === true){
            $this->addFlash('warning', 'Incorrect stats');
            return $this->redirectToRoute("my_hero");
        }
        $arrRequest['hero']['money'] = $money;
        if($this->heroService->edit($hero, $arrRequest)){
            $this->addFlash('info', 'Update hero successfully');
            return $this->redirectToRoute("my_hero");
        }else{
            $this->addFlash('warning', 'Something is wrong, try again');
            return $this->redirectToRoute("my_hero");
        }

    }

    public function currentHeroOrById($id=null)
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if ($id == null){
            return $this->getDoctrine()
                ->getRepository(Hero::class)
                ->findOneBy(['ownerId'=>$user->getId()]);
        }else{
            return $this->getDoctrine()
                ->getRepository(Hero::class)
                ->find($id);
        }

    }

}
