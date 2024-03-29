<?php


namespace SoftUniBlogBundle\Service\Users;


use SoftUniBlogBundle\Entity\Role;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Repository\UserRepository;
use SoftUniBlogBundle\Service\Encryption\ArgonEncryption;
use SoftUniBlogBundle\Service\Encryption\BCryptService;
use SoftUniBlogBundle\Service\Encryption\EncryptionServiceInterface;
use SoftUniBlogBundle\Service\Roles\RoleServiceInterface;
use SoftUniBlogBundle\Service\Users\UserServiceInterface;
use Symfony\Component\Security\Core\Security;

class UserService implements UserServiceInterface
{
    private $security;
    private $userRepository;
    private $encryptionService;
    private $roleService;

    public function __construct(Security $security,
                                UserRepository $userRepository,
                                BCryptService $encryptionService,
                                RoleServiceInterface $roleService)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->encryptionService = $encryptionService;
        $this->roleService = $roleService;

    }

    public function register(User $user)
    {

        return true;
    }

    /**
     * @param string $email
     * @return null|User|object
     */
    public function findOneByEmail(string $email):?User
    {

        return $this->userRepository->findOneBy(['email'=>$email]);
    }

    public function save(User $user): bool
    {

        $passwordHash =
           $this->encryptionService->hash($user->getPassword());
        $user->setPassword($passwordHash);

        $userRole = $this->roleService->findOneBy("ROLE_USER");

        if ($user->getRoles() == null){
            $user->addRole($userRole);
        }


        return $this->userRepository->insert($user);
    }

    /**
     * @param int $id
     * @return User|null|object
     */
    public function findOneById(int $id): ?User
    {

        return $this->userRepository->find($id);
    }

    /**
     * @param User $user
     * @return User|null|object
     */
    public function findOne(User $user): ?User
    {

        return $this->userRepository->find($user);
    }

    /**
     * @return User|null|object
     */
    public function currentUser(): ?User
    {

       return $this->security->getUser();
    }

    public function findAll()
    {
        return $this->userRepository->findAll();
    }
}