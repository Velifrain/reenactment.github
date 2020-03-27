<?php
declare(strict_types=1);

namespace User\Factory\Form;

use Interop\Container\ContainerInterface;
use User\Form\LoginForm;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class LoginFormFactory
 * @package User\Factory\Form
 */
class LoginFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return LoginForm
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : LoginForm
    {
        return new LoginForm();
    }
}