<?php
declare(strict_types=1);

namespace User\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\ServiceManager;

class UserService
{
    /** @var EntityManager $em */
    private $em;

    /** @var ServiceManager $sm */
    private $sm;

    /** @var AuthenticationService $authServise */
    private $authService;

    public function __construct(EntityManager $em, ServiceManager $sm, AuthenticationService $authService)
    {
        $this->em = $em;
        $this->sm = $sm;
        $this->authService = $authService;
    }



    public function getUsers()
    {
        return $this->em->getRepository(User::class)
            ->findAll([]);
    }

}