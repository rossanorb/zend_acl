<?php

class Application_Model_Users implements Zend_Acl_Role_Interface {

    private $_userName;
    private $_roleId;
    private $id_role;
    private $_fullName;

    public function getUserName() {
        return $this->_userName;
    }

    public function setUserName($userName) {
        $this->_userName = (string) $userName;
    }

    public function getFullName() {
        return $this->_fullName;
    }

    public function setFullName($fullName) {
        $this->_fullName = (string) $fullName;
    }

    /**
     *
     */
    public function getRoleId() {
        return $this->_roleId;
    }

    public function setRoleId($roleId) {
        $this->_roleId = (string) $roleId;
    }
    
    public function setRoleCod($id_role){
        $this->id_role = $id_role;
    }
    
    public function getRoleCod(){
        return $this->id_role;
    }

}
