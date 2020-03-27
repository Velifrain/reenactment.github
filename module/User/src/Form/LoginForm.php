<?php
declare(strict_types=1);

namespace User\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Filter;

/**
 * Class LoginForm
 * @package User\Form
 */
class LoginForm extends Form implements InputFilterProviderInterface
{
    /**
     * LoginForm constructor.
     */
    public function __construct()
    {
        parent::__construct('login');

        $this->add([
            'name' => 'email',
            'type' => Text::class,
        ]);

        $this->add([
            'name' => 'password',
            'type' => Password::class,
        ]);

        $this->add(
            [
                'name' => 'csrf',
                'type' => Csrf::class,
                'options' => [
                    'csrf_options' => [
                        'timeout' => 60 * 5
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name' => 'submit',
                'type' => Submit::class,
                'attributes' => [
                    'value' => 'Login',
                ],
            ]
        );
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification(): array
    {
        return [
            'email' => [
                'filters' => [
                    ['name' => Filter\StringTrim::class],
                    ['name' => Filter\StripTags::class],
                ],
            ],

            'password' => [
                'filters' => [
                    ['name' => Filter\StringTrim::class],
                    ['name' => Filter\StripTags::class],
                ],
            ],
        ];
    }
}