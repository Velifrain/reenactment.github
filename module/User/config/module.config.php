<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use User\Entity\User;
use User\Factory\Controller\UserControllerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity',
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],

        'authentication' => [
            'orm_default' => [
                'object_manager' => EntityManager::class,
                'identity_class' => User::class,
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function (User $user, $inputPassword) {
                    return password_verify($inputPassword, $user->getPassword());
                }
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\UserController::class => Factory\Controller\UserControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factory' => [
            Service\UserService::class => Factory\Service\UserServiceFactory::class,
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
