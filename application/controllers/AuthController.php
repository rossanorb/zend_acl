<?php

class AuthController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        return $this->_helper->redirector('login');
    }

    public function loginAction() {
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->view->messages = $this->_flashMessenger->getMessages();
        $form = new Application_Form_Login();
        $this->view->form = $form;
        
        if( $this->getRequest()->isPost() ){
            $data = $this->getRequest()->getPost();
            
            if($form->isValid($data)){
                $login = $form->getValue('login');
                $senha = $form->getValue('senha');
                
                try {
                    Application_Model_Auth::login($login, $senha);
                    //Redireciona para o Controller protegido
                    return $this->_helper->redirector->goToRoute( array('controller' => 'noticias'), null, true);
                } catch (Exception $e) {
                    //Dados inválidos
                    $this->_helper->FlashMessenger($e->getMessage());
                    $this->_redirect('/auth/login');                    
                }
                        }else{
                $form->populate($data);
            }
        }
    }

    public function logoutAction() {

        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        return $this->_helper->redirector('index');
    }

}
