<?php
declare(strict_types=1);

namespace User\Factory\Controller;

use Interop\Container\ContainerInterface;
use User\Controller\UserController;
use User\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UserController($container->get(UserService::class));
    }
}