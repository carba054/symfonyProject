<?php

namespace SoftUniBlogBundle\Controller;

use SoftUniBlogBundle\Entity\Hero;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="blog_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $heroes = $this
            ->getDoctrine()
            ->getRepository(Hero::class)
            ->findBy([],['level' => 'DESC','wins'=> 'DESC','dateAdded'=>'ASC']);

        return $this->render('home/index.html.twig',['heroes' =>$heroes,'url'=>$_SERVER['REQUEST_URI']]);
    }

/**
 * *@Route("sort/{by}/{top}", name="sort")
 * @param $by
 * @return \Symfony\Component\HttpFoundation\Response
 */

    public function indexSort($by,$top)
    {

        $order = 'DESC';
        if ($top == 0){
            $order = 'ASC';
        }
        $heroes = $this
            ->getDoctrine()
            ->getRepository(Hero::class)
            ->findBy([],[$by => $order]);

        return $this->render('home/index.html.twig',['heroes' =>$heroes,'url'=>$_SERVER['REQUEST_URI']]);
    }
}
