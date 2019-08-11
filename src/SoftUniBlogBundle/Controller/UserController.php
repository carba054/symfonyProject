<?php

namespace SoftUniBlogBundle\Controller;

use mysql_xdevapi\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Magics;
use SoftUniBlogBundle\Entity\Role;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\MagicType;
use SoftUniBlogBundle\Form\UserType;
use SoftUniBlogBundle\Service\Magics\MagicService;
use SoftUniBlogBundle\Service\Magics\MagicServiceInterface;
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
    /**
     * @var MagicServiceInterface
     */
    private $magicService;

    public function __construct(UserServiceInterface $userService,MagicServiceInterface $magicService)
    {
        $this->userService = $userService;
        $this->magicService = $magicService;
    }

    /**
     * @Route("register", name="user_register", methods={"GET"})
     * @param $request
     * @return Response
     */
    public function register($request=null)
    {

        return $this->render('users/register.html.twig',[
            'form' => $this->createForm(UserType::class)->createView(),'request'=>$request
        ]);
    }

    /**
     * @Route("/profile/{id}", name="user_profile")
     * @param $id
     * @return Response
     */
    public function profile($id=null){


        if ($id===null){
            return $this->render("users/profile.html.twig",
                ['user'=>$this->userService->currentUser()]);
        }else{
            return $this->render("users/profile.html.twig",
                ['user'=>$this->userService->findOneById($id)]);
        }


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
        $req = $request->request->all();
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        try{
        $form->handleRequest($request);
        }catch (\Exception $e){
            $this->addFlash('warning', $e->getMessage());
            return $this->register($req);
            //return $this->redirectToRoute('user_register');
        }

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
        if($user->isAdmin()){
            $req = $request->request->all();
            $user = $this->userService->findOneById($req['userId']);
        }



        if (null === $user) {
            return $this->redirectToRoute("blog_index");
        }

        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $this->userService->save($user)) {

            return $this->redirectToRoute("blog_index");

        }
        return $this->render('users/edit.html.twig',
            ['form' => $form->createView(),
                'user' => $user]);
    }

    /**
     * @Route("edit/{id}", name="edit_profile", methods={"GET"})
     * @param Request $id
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editForAdmin($id)
    {

        /**
         * @var User $user
         */
        $user = $this->getUser();

        if ($user->isAdmin()){


            return $this->edit($id);
        }

        return $this->redirectToRoute("blog_index");


    }

    /**
     * @Route("edit", name="edit", methods={"GET"})
     * @param Request $id
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit($id=null)
    {


        /**
         * @var User $user
         * @var User $isAdmin
         */
        $isAdmin = $this->getUser();
        if ($id != null && $isAdmin->isAdmin()){
            $user = $this->userService->findOneById($id);
        }else{
            $user = $this->getUser();
        }


        if ($user != null){

            return $this->render('users/edit.html.twig',[
                'form' => $this->createForm(UserType::class)->createView(),
                'user' => $user
            ]);
        }

        return $this->redirectToRoute("blog_index");


    }

    /**
     * @Route("users", name="users_view", methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function viewUsers()
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if ($user->isAdmin()){
            return $this->redirectToRoute("blog_index");

        }
        $users = $this->userService->findAll();
        return $this->render('users/view_users.html.twig',['users'=>$users]);


    }

    /**
     * @Route("addMagics", name="add_magic", methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function addMagic()
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if (!$user->isAdmin()) {

            return $this->redirectToRoute("blog_index");
        }
        return $this->render('magics/add_magic.html.twig');

    }

    /**
     * @Route("addMagics", methods={"POST"})
     * @param $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function addMagicProcess(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if (!$user->isAdmin()) {

            return $this->redirectToRoute("blog_index");
        }
        $req = $request->request->all();


        if (!isset($req['magics']['type'])){
            $this->addFlash('info', 'Please choose type!');
            return $this->render('magics/add_magic.html.twig');
        }
        $magic = new Magics($req['magics']['img'], $req['magics']['dmg'], $req['magics']['percentChance'], $req['magics']['armor'], $req['magics']['dodge'], $req['magics']['heal'], $req['magics']['name'], $req['magics']['description'], $req['magics']['type'], $req['magics']['critical']);
        //$form = $this->createForm(MagicType::class,$magic);
        //$form->handleRequest($request);



        if ($this->magicService->save($magic)){
            $this->addFlash('info', 'The magic was added!');
            return $this->redirectToRoute("blog_index");
        }
        return $this->render('magics/add_magic.html.twig');

    }




}
