<?php
declare(strict_types=1);

namespace User\Controller;

use Doctrine\ORM\Cache;
use User\Form\UserForm;
use User\Service\UserService;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Plugin\Prg\PostRedirectGet;


class UserController extends AbstractActionController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        return new ViewModel(
            [
                'users' => $this->userService->getUsers()
            ]
        );
    }

    /**
     * @return ViewModel
     * @throws \Exception
     */
    public function addAction(): ViewModel
    {
        /** @var Request $request */
        $request = $this->getRequest();

        /** @var UserForm $form */
        $form = $this->userService->getUserForm();

        if ($request->isPost()) {
            $form->setData($this->params()->fromPost());

            if ($this->userService->addUser()) {
                $this->redirect()->toRoute('user', ['action' => 'add']);
            }
        }

        return new ViewModel(['form' => $form]);
    }

    /**
     * @return array|\Zend\Http\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction()
    {

        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('user');
        }

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Cancel');

            if ($del == 'Delete') {
                $id = (int)$request->getPost('id');
                $this->userService->deleteUser($id);
            }

            // Redirect to list of users
            return $this->redirect()->toRoute('user');
        }

        return [
            'id' => $id,
            'user' => $this->userService->getUserId($id),
        ];
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function loginAction()
    {
        $this->layout('layout/auth');

        if ($this->userService->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('user');
        }

        $form = $this->userService->getLoginForm();
        /** @var Request $request */
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($this->params()->fromPost());

            if ($form->isValid()) {
                $formData = $form->getData();
                $result = $this->userService->login($formData);

                if ($result->isValid()) {
                    return $this->redirect()->toRoute('user');
                } else {
                    /** @var FlashMessenger $flashMessenger */
                    $flashMessenger = $this->flashMessenger();
                    $flashMessenger->addErrorMessage('Incorrect Email or/and password. Please try again');
                    return $this->redirect()->refresh();
                }

            } else {
                /** @var FlashMessenger $flashMessenger */
                $flashMessenger = $this->flashMessenger();
                $flashMessenger->addErrorMessage('Incorrect Email or/and password. Please try again');
                return $this->redirect()->refresh();
            }
        }
        return new ViewModel([
            'form' => $form,
        ]);
    }

    /**
     * @return \Zend\Http\Response
     */
    public function LogoutAction()
    {
        $this->userService->logout();
        return $this->redirect()->toRoute('user', ['action' => 'login']);
    }
}
