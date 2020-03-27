<?php
declare(strict_types=1);

namespace User;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use User\Entity\User;
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
        'factories' => [
            // Form
            Form\UserForm::class => Factory\Form\UserFormFactory::class,
            Form\LoginForm::class => Factory\Form\LoginFormFactory::class,

            // Service
            Service\UserService::class => Factory\Service\UserServiceFactory::class,
        ]
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
