<?php
declare(strict_types=1);

namespace User\Factory\Form;


use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use User\Form\UserFieldset;
use User\Form\UserForm;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class UserFormFactory
 * @package User\Factory\Form
 */
class UserFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|NULL $options
     *
     * @return UserForm
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL): UserForm
    {
        /** @var EntityManager $sm */
        $em = $container->get(EntityManager::class);

        return new UserForm(new UserFieldset($em));
    }
}