<?php

class Aplicacao_Acl_Setup extends Zend_Controller_Plugin_Abstract {

    /**
     * @var Zend_Acl
     */
    protected $_acl;
    private $ca;
    private $_auth;
    private $role;
    private $id_role;

    public function __construct() {
        $this->_acl = new Zend_Acl();
        $this->_initialize();
    }

    protected function _initialize() {
        $this->_setupRoles();
        $this->_setupResources();
        $this->_setupPrivileges();
        $this->_saveAcl();
    }

    protected function _setupRoles() {
        $this->_auth = Zend_Auth::getInstance();
        $this->ca = new Application_Model_Acl();

        if ($this->_auth->hasIdentity()) { // se autenticado pega role da sessão                    
            $identity = $this->_auth->getIdentity(); // busca informações guardadas no storage na autenticação
            $this->id_role =  $identity->getRoleCod();
            $this->role = $identity->getRoleId();
            $this->_acl->addRole(new Zend_Acl_Role($this->role));
            
        } else {  // senão define um role padrão
            try { // busca role padrão no banco
                $role = $this->ca->getDefault();
                $this->id_role = $role->id_role;
                $this->role = $role->role;
                
            } catch (Exception $ex) {
                $this->show_erro($ex);
            }
            $this->_acl->addRole(new Zend_Acl_Role($this->role));
        }
    }

    protected function _setupResources() {
        $resources = $this->ca->getResources();
        foreach ($resources as $resource) {
            $this->_acl->addResource(new Zend_Acl_Resource($resource['controller']));
        }
    }

    protected function _setupPrivileges() {
        
        $userAllowedResources = $this->ca->getupPrivileges($this->id_role);
            
        
        foreach ($userAllowedResources as $controller => $Actions) {
            $arrayAllowedActions = array();
            foreach ($Actions as $Action) {
                echo $this->role . ' - ' .  $controller . ' - ' . $Action  . '<br>';
                $arrayAllowedActions[] = $Action;
            }
             $this->_acl->allow($this->role, $controller, $arrayAllowedActions);
        }
    }

    protected function _saveAcl() {
        $registry = Zend_Registry::getInstance();
        $registry->set('acl', $this->_acl);
    }

    private function show_erro(Exception $ex) {        
        echo "<br>Local: " . get_class();
        echo "<br>Descri&ccedil;&atilde;o:" . $ex->getMessage();
        exit();
    }

}
