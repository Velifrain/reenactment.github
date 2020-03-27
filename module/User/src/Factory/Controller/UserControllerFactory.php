<?php
declare(strict_types=1);

namespace User\Factory\Controller;


use Interop\Container\ContainerInterface;
use User\Controller\UserController;
use User\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class UserControllerFactory
 * @package User\Factory\Controller
 */
class UserControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|NULL $options
     * @return UserController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL): UserController
    {
        return new UserController($container->get(UserService::class));
    }
}