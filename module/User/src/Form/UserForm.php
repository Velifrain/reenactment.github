<?php
declare(strict_types=1);

namespace User\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

/**
 * Class UserForm
 * @package User\Form
 */
class UserForm extends Form
{
    /**
     * UserForm constructor.
     * @param UserFieldset $userFieldset
     */
    public function __construct(UserFieldset $userFieldset)
    {
        parent::__construct('user-form');

        $userFieldset->setUseAsBaseFieldset(true);
        $this->add($userFieldset);

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
                    'value' => 'Save',
                ],
            ]
        );
    }

}