<?php
namespace Core\Entity;

use Core\Test\EntityTestCase;



class UsersTest extends EntityTestCase
{
    public function testGetInputFilter()
    {
        $user = new  \Core\Entity\System\Users;
        $if = $user->getInputFilter();
        $this->assertInstanceOf('Zend\InputFilter\InputFilter',$if);
        return $if;
    }
    
    public function testInputFilterValid()
    {
        $user = new  \Core\Entity\System\Users;
        $if = $user->getInputFilter(); 
        $this->assertEquals('12',$if->count());
        
        $this->assertTrue($if->has('id'));
        $this->assertTrue($if->has('userName'));
        $this->assertTrue($if->has('password'));
        $this->assertTrue($if->has('fullName'));
    }
    
    public function testValidInsert()
    {
        $user = $this->addUser();
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        $this->assertEquals('1',$user->getId());      
        
    }
    
    
    public function testValidUpdate(){
        $user = $this->addUser();
        $user->setFullName("Outro Nome");
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        
        $this->assertEquals('1',$user->getId());
        $dados = $this->getEntityManager()->getRepository('Core\Entity\System\Users')->find('1');
        $this->assertEquals('Outro Nome',$dados->getFullName());
        
    }
    
    
    public function testDeleteValid(){
        
        $user = $this->addUser();
        $user->setFullName("Outro Nome");
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        $this->assertEquals('1',$user->getId());
        
        $dados = $this->getEntityManager()->getRepository('Core\Entity\System\Users')->find('1');
        $this->getEntityManager()->remove($dados);
        $deleted = $this->getEntityManager()->flush();
        
        $dados = $this->getEntityManager()->getRepository('Core\Entity\System\Users')->find('1');
        $this->assertEquals(null,$dados);
        
        
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
    
        return $model;
    
    }
	
}