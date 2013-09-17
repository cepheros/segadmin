<?php

namespace Application\Controller;

use Core\Test\ControllerTest;
use Zend\Http\Request;

/**
 * Testes do controller IndexController
 *
 * @category Application
 * @package Controller
 * @author  Daniel Chaves<daniel@danielchaves.com.br>
 */

/**
 * @group Controller
 */
class AuthControllerTest extends ControllerTest
{

    /**
     * Namespace completa do Controller
     * @var string
     */
    protected $controllerFQDN = 'Application\Controller\AuthController';

    /**
     * Nome da rota. Geralmente o nome do módulo
     * @var string
     */
    protected $controllerRoute = 'application';

    /**
     * Testa ação index
     * @return void
     */
    public function testIndexAction()
    {
        // Invoca a rota index
        $this->routeMatch->setParam('action', 'index');

        $result = $this->controller->dispatch($this->request, $this->response);

        // Verifica o response
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        // Testa se um ViewModel foi retornado
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    public function testNotFoundAction()
    {
        // Invoca a rota index
        $this->routeMatch->setParam('action', 'nao-existo');

        $result = $this->controller->dispatch($this->request, $this->response);

        // Verifica o response
        $response = $this->controller->getResponse();

        $this->assertEquals(404, $response->getStatusCode());

    }

    public function testLoginAction()
    {
        $user = $this->addUser();
        
        $this->assertEquals('drchav',$user->getUserName());
        $this->assertNotNull($user->getId());
        $this->assertEquals(sha1(md5('q1p0w2o9')),$user->getPassword());
        
        $this->request->getPost()->set("userName", $user->getUserName() );
        $this->request->getPost()->set("password", 'q1p0w2p9' );
        
        $this->routeMatch->setParam('action', 'auth');
        $result = $this->controller->dispatch($this->request, $this->response);
        $response = $this->controller->getResponse();
       
        $this->assertEquals(302, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertEquals('Location: /application/auth', $headers->get('Location'));

    }
    
    
    public function testErrorLoginAction()
    {
        $user = $this->addUser();
    
        $this->assertEquals('drchav',$user->getUserName());
        $this->assertNotNull($user->getId());
       
        
    
        $this->request->getPost()->set("userName", $user->getUserName() );
        $this->request->getPost()->set("password", 'Mequetrefe' );
    
        $this->routeMatch->setParam('action', 'auth');
        $result = $this->controller->dispatch($this->request, $this->response);
        $response = $this->controller->getResponse();
         
        $this->assertEquals(302, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertEquals('Location: /application/auth', $headers->get('Location'));
    
    }
    
    
    
    public function testLogoutAction(){
        $user = $this->addUser();
        
        $this->routeMatch->setParam('action', 'logout');
        $result = $this->controller->dispatch($this->request, $this->response);
        
        // Verifica o response
        $response = $this->controller->getResponse();
        //deve ter redirecionado
        $this->assertEquals(302, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertEquals('Location: /application/auth', $headers->get('Location'));
    }
    
    
    
    private function addUser(){
        $model = new \Core\Entity\System\Users();
        $model->setFullName("Daniel Chaves");
        $model->setPassword(sha1(md5('q1p0w2o9')));
        $model->setUserName('drchav');
        $model->setUserEmail("daniel@danielchaves.com.br");
        $model->setUserSignature("Teste");
        $model->setPhoneNumber("11945074004");
        $model->setRole('SYSUSER');
        $model->setIpLastLogin('127.0.0.1');
        $model->setDateCreated(new \DateTime('now'));
        $this->getEntityManager()->persist($model);
        $this->getEntityManager()->flush();

        return $model;
        
    }
    
  
    public function testLoginInvalidMethod()
    {
        $user = $this->addUser();
        $this->routeMatch->setParam('action', 'auth');
        $result = $this->controller->dispatch($this->request, $this->response);
        $response = $this->controller->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $headers = $response->getHeaders();
        $this->assertEquals('Location: /application/auth', $headers->get('Location'));
        
    
    }

}
