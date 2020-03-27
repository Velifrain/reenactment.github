<?php
declare(strict_types=1);

namespace User\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use User\Entity\User;
use Zend\Filter;
use Zend\Form\Element\Password;
use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator;

/**
 * Class UserFieldset
 * @package User\Form
 */
class UserFieldset extends Fieldset implements InputFilterProviderInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * UserFieldset constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct('user');

        $this->em = $em;
        $this->setHydrator(new DoctrineHydrator($em, User::class));
        $this->setObject(new User());

        $this->add([
            'name' => 'email',
            'type' => Text::class,
            'options' => [
                'label' => 'Email',
            ],
        ]);

        $this->add([
            'name' => 'password',
            'type' => Password::class,
            'options' => [
                'label' => 'Password',
            ],
        ]);

        $this->add([
            'name' => 'confirm',
            'type' => Password::class,
            'options' => [
                'label' => 'Confirm password',
            ],
        ]);
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification(): array
    {
        return [
            'email' => [
                'required' => true,
                'filters' => [
                    ['name' => Filter\StringTrim::class],
                    ['name' => Filter\StripTags::class],

                ],
                'validators' => [
                    [
                        'name' => Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 50
                        ],
                    ],
                    ['name' => Validator\EmailAddress::class],
                ],
            ],

            'password' => [
                'required' => true,
                'filters' => [
                    ['name' => Filter\StringTrim::class],
                    ['name' => Filter\StripTags::class],
                ],
                'validators' => [
                    [
                        'name' => Validator\StringLength::class,
                        'options' => [
                            'min' => 8,
                            'max' => 32
                        ],
                    ],
                    [
                        'name' => Validator\Regex::class,
                        'options' => [
                            'pattern' => '/[A-Za-z\d]/'
                        ]
                    ],
                ],
            ],

            'confirm' => [
                'required' => true,
                'filters' => [
                    ['name' => Filter\StringTrim::class],
                    ['name' => Filter\StripTags::class],
                ],
                'validators' => [
                    [
                        'name' => Validator\Identical::class,
                        'options' => [
                            'token' => 'password',
                        ],
                    ],
                ],
            ]
        ];
    }
}