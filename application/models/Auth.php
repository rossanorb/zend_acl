<?php

class Application_Model_Auth{
    
	public static function login($login, $senha){
            
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		//Inicia o adaptador Zend_Auth para banco de dados
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
		$authAdapter->setTableName('users')
                            ->setIdentityColumn('login')
                            ->setCredentialColumn('password')
                            ->setCredentialTreatment('SHA1(?)');
		//Define os dados para processar o login
		$authAdapter->setIdentity($login)
                            ->setCredential($senha);
		//Faz inner join dos dados do perfil no SELECT do Auth_Adapter
		$select = $authAdapter->getDbSelect();
                $select->join( 'roles', 'roles.id_role = users.id_role', array('role_roles' => 'role', 'id_role') );                
		//Efetua o login
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($authAdapter);
               
		//Verifica se o login foi efetuado com sucesso
		if ( $result->isValid() ) {
			//Recupera o objeto do usuário, sem a senha
			$info = $authAdapter->getResultRowObject(null, 'password');
	
			$usuario = new Application_Model_Users();
			$usuario->setFullName( $info->nome );
			$usuario->setUserName( $info->login );
			$usuario->setRoleId( $info->role_roles );
                        $usuario->setRoleCod($info->id_role );			                        
                        
			$storage = $auth->getStorage();
			$storage->write($usuario);
	
			return true;
		}
		throw new Exception('Nome de usuário ou senha inválida');
	}
}