<?php

namespace SoftUniBlogBundle\Controller;

use mysql_xdevapi\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Role;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\UserType;
use SoftUniBlogBundle\Service\Users\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface;
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("register", name="user_register", methods={"GET"})
     * @param $request
     * @return Response
     */
    public function register(Request $request)
    {

        return $this->render('users/register.html.twig',[
            'form' => $this->createForm(UserType::class)->createView()
        ]);
    }

    /**
     * @Route("/profile", name="user_profile")
     */
    public function profile(){

        return $this->render("users/profile.html.twig",
            ['user'=>$this->userService->currentUser()]);
    }
    /**
     * @Route("/logout", name="security_logout")
     *
     */
    public function logout(){

        throw new Exception("Logout failed!");
    }

    /**
     * @Route("register", methods={"POST"})
     * @param $request
     * @return Response
     */
    public function registerProcess(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);


        $this->userService->save($user);
        return $this->redirectToRoute('login');

    }


    /**
     * @Route("edit", methods={"POST"})
     * @param $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function editProcess(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();


        if (null === $user) {
            return $this->redirectToRoute("blog_index");
        }

        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $this->userService->save($user);

            return $this->redirectToRoute("blog_index");

        }
        return $this->render('users/edit.html.twig',
            ['form' => $form->createView(),
                'user' => $user]);
    }

    /**
     * @Route("edit", name="edit", methods={"GET"})
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request)
    {
        $user = $this->getUser();
        return $this->render('users/edit.html.twig',[
            'form' => $this->createForm(UserType::class)->createView(),
            'user' => $user
        ]);

    }



}
