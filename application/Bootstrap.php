<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload(){
            // Add autoloader empty namespace
            $autoLoader = Zend_Loader_Autoloader::getInstance();
            $autoLoader->registerNamespace('Aplicacao_');
            // Return it so that it can be stored by the bootstrap
            return $autoLoader;
	}
        
public function _initRegistry()
{
    $this->bootstrap('db'); // Bootstrap the db resource from configuration

    $db = $this->getResource('db'); // get the db object here, if necessary

    // now that you have initialized the db resource, you can use your dbtable object
    
    Zend_Registry::set('db', $db );
}        

}

