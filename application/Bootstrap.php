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

}

