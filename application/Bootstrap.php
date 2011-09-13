<?php

/**
 * Application bootstrap
 * 
 * @uses    Zend_Application_Bootstrap_Bootstrap
 * @package QuickStart
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected $_session;
	protected $_logger;
		 	
    /**
     * Bootstrap autoloader for application resources
     * 
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;       
    }   
    

    /**
     * Bootstrap the view doctype
     * 
     * @return void
     */
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
    protected function _initSession()
    {
    	$this->_session = new Zend_Session_Namespace('overton');
     	Zend_Registry::set('session', $this->_session);
     	     	     	
     	//dodanie obiektu logger
     	$this->_logger = new Zend_Log();
     	$writer = new Zend_Log_Writer_Stream('logowanie.log', 'a');				
		$this->_logger->addWriter($writer);
		
		$session = Zend_Registry::get('session');
      	$session->logger = $this->_logger;
      	
		/**
		 *  EMERG   = 0;  // Emergency: system is unusable
			ALERT   = 1;  // Alert: action must be taken immediately
			CRIT    = 2;  // Critical: critical conditions
			ERR     = 3;  // Error: error conditions
			WARN    = 4;  // Warning: warning conditions
			NOTICE  = 5;  // Notice: normal but significant condition
			INFO    = 6;  // Informational: informational messages
			DEBUG   = 7;  // Debug: debug messages
		 */ 	
    }
}
