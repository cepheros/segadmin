<?php
namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;

/**
 * AuthController
 *
 * PHP version 5.4
 *
 * @category   SegAdmin
 * @package    Application
 * @subpackage Auth
 * @author     Daniel Chaves <daniel@danielchaves.com.br>
 * @license    http://mywedding.com.br/licence MIT
 * @link       none
 */

class AuthController extends CoreController
{
    public function indexAction()
    {
        $view = new ViewModel();
        $view->setTerminal(true);

        return $view;

    }

    public function authAction()
    {
        $request = $this->getRequest();
        if(!$request->isPost()){
            $this->redirect()->toUrl('/application/auth');
        }
        
        $data = $request->getPost();
        $service = $this->getService('Core\Service\Auth\System');
        try{
            $auth = $service->authenticate(
                array(
                    'userName' => $data['userName'],
                    'password' => $data['password']
                )
            );
            return $this->redirect()->toUrl('/application/dashboard');
            
        }catch (\Exception $e){
            return $this->redirect()->toUrl('/application/auth/index/error/login');
        }
        

    }

    public function logoutAction()
    {
        $service = $this->getService('Core\Service\Auth\System');
        $auth = $service->logout();
        return $this->redirect()->toUrl('/application/auth');

    }
}
