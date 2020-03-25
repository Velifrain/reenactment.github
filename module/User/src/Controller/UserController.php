<?php

namespace User\Controller;

use User\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 * @package User\Controller
 */
class UserController extends AbstractActionController
{
    /** @var UserService $service */
    private $service;

    /**
     * UserController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        return new ViewModel();
    }
}
