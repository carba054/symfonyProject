<?php

namespace SoftUniBlogBundle\Controller;

use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Service\Encryption\EncryptionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use SoftUniBlogBundle\Form\UserType;

use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{

    /**
     * @var EncryptionServiceInterface;
     */
    private $encryptionServiceInterface;

    public function __construct(EncryptionServiceInterface $encryptionServiceInterface)
    {
        $this->encryptionServiceInterface = $encryptionServiceInterface;
    }

    /**
     * @Route("/login",name="security_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();


        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig');
    }


    /**
     * @Route("/edit",name="edit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editProfile(AuthenticationUtils $authenticationUtils){

        /**
         * @var User $user
         */
        $user = $this->getUser();

        return $this->render('security/edit.html.twig',[
            'form' => $this->createForm(UserType::class)->createView(),
            'user' => $user]);
    }


}
