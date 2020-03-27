<?php
declare(strict_types=1);

namespace User\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use User\Entity\User;
use User\Form\UserForm;
use User\Form\LoginForm;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Crypt\Password\Bcrypt;
use Laminas\ServiceManager\ServiceManager;


/**
 * Class UserService
 * @package User\Service
 */
class UserService
{
    /**
     * @var ServiceManager
     */
    private $sm;

    /**
     * @var EntityManager
     */
    private $em;

    /** @var AuthenticationService $authService */
    private $authService;

    /**
     * UserService constructor.
     * @param ServiceManager $sm
     * @param EntityManager $em
     * @param AuthenticationService $authService
     */
    public function __construct(ServiceManager $sm, EntityManager $em, AuthenticationService $authService)
    {
        $this->sm = $sm;
        $this->em = $em;
        $this->authService = $authService;
    }

    /**
     * @return User
     */
    /**
     * @param User $mail
     */
    public function setMail(User $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @param User $password
     */
    public function setPassword(User $password): void
    {
        $this->password = $password;
    }

    /**
     * @return UserForm
     */
    public function getUserForm(): UserForm
    {
        return $this->sm->get(UserForm::class);
    }

    /**
     * @return loginForm
     */
    public function getLoginForm(): loginForm
    {
        return $this->sm->get(LoginForm::class);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function addUser(): bool
    {
        $form = $this->getUserForm();

        if ($form->isValid()) {
            $user = $form->getData();

            $bcrypt = new Bcrypt();
            $user->setPassword($bcrypt->create($user->getPassword()));

            try {
                $this->em->persist($user);
                $this->em->flush();
                // todo: implement handler
            } catch (ORMInvalidArgumentException $ORMInvalidArgumentException) {
                throw $ORMInvalidArgumentException;
            } catch (OptimisticLockException $optimisticLockException) {
                throw $optimisticLockException;
            } catch (\Exception $e) {
                throw $e;
            }

            return true;
        }

        return false;
    }

    /**
     * @return array|object[]
     */
    public function getUsers(): array
    {
        return $this->em->getRepository(User::class)
            ->findAll([]);
    }

    /**
     * @param $id
     * @throws OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function deleteUser(int $id)
    {
        $user = $this->em->getRepository(User::class)
            ->find($id);

        $this->em->remove($user);
        $this->em->flush();

    }

    /**
     * @param int $id
     * @return int|object|null
     */
    public function getUserId(int $id)
    {
        $id = $this->em->getRepository(User::class)->find($id);

        return $id;
    }

    /**
     * @param $formData
     * @return \Zend\Authentication\Result
     */
    public function login($formData)
    {
        /** @var CallbackCheckAdapter $adapter */
        $adapter = $this->authService->getAdapter();
        $adapter->setIdentity($formData['email']);
        $adapter->setCredential($formData['password']);
        $result = $this->authService->authenticate();

        return $result;
    }

    public function logout()
    {
        $this->authService->clearIdentity();
        return true;
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthService(): AuthenticationService
    {
        return $this->authService;
    }

}