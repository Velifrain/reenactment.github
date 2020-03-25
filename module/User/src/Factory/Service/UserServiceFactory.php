<?php
declare(strict_types=1);

namespace User\Factory\Service;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use User\Service\UserService;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class UserServiceFactory
 * @package User\Factory\Service
 */
class UserServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ServiceManager $sm */
        $sm = $container->get(ServiceManager::class);

        /** @var EntityManager $sm */
        $em = $container->get(EntityManager::class);

        /** @var AuthenticationService $authService */
        $authService = $container->get('doctrine.authenticationservice.orm_default');

        return new UserService($sm, $em, $authService);
    }

}