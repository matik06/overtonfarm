<?php

class Model_ManagmentController extends Zend_Controller_Action
{	
	/**
	 * manage permission on website
	 * @see library/Zend/Controller/Zend_Controller_Action#init()
	 */
	public function init()
	{	
		$user;
		$auth = Zend_Auth::getInstance();
		
		// check is user logged
		if(!$auth->hasIdentity())
		{			
			//if no then i set for him default role: 'guest'
			$user = new Model_User();
			$user->setRole(array('guest'));	
		}
		else
		{
			//if user is logget then we get user details
			$user = $auth->getIdentity();
		}		
		
		$allowed = false;
		//get all user roles
		$roles = $user->getRole();
		
		$allowed = $this->checkPermission($roles);
		
		//if user does't have permission
		if(!$allowed)
		{
			if($auth->hasIdentity())
			{
				$this->_redirect('/index/nopermission');	
			}
			else
			{
				$this->_redirect('/index/login');
			}
		}		
	}
	
	/**
	 * Check permission for Rolename
	 * 
	 * @param (string) $roleName
	 * @return bool
	 */
	public function checkPermission($roles)
	{
		$controllerName = $this->getRequest()->getControllerName();
		$actionName = $this->getRequest()->getActionName();
		$acl = $this->getAcl();
		
		foreach($roles as $roleName)
		{
			//check permission for user
			if($acl->isAllowed($roleName, $controllerName, $actionName))
			{				
				return true;			
			}
		}
		
		return false;
	}
	
	static public function checkPermissionStatic($roles, $resources)
	{
		$acl = new Zend_Acl();		
		
		//define our possible user groups
		$acl->addRole(new Zend_Acl_Role('guest'));
		
		//moderator have at least same access as guest
		$acl->addRole(new Zend_Acl_Role('moderator'), array('guest'));

		$acl->addRole(new Zend_Acl_Role('administrator'));
		
		// define our controllers as resources.
	    $acl->add(new Zend_Acl_Resource('index'));
	    $acl->add(new Zend_Acl_Resource('farmmachinery'));
	    $acl->add(new Zend_Acl_Resource('others'));
	    $acl->add(new Zend_Acl_Resource('planthire'));
	    $acl->add(new Zend_Acl_Resource('telescopichandlers'));
	    $acl->add(new Zend_Acl_Resource('tractors'));
	    $acl->add(new Zend_Acl_Resource('parts'));
		$acl->add(new Zend_Acl_Resource('moderator'));
		$acl->add(new Zend_Acl_Resource('administrator'));		
		
		// define our access rules
	    $acl->allow('guest', array('index', 'farmmachinery',
	    						 'others', 'planthire', 'telescopichandlers', 'tractors', 'parts'));
	    $acl->allow('moderator', 'moderator');
		
		 // admins can get to everything
	    $acl->allow('administrator');	    
		
		foreach($roles as $roleName)
		{
			//check permission for user
			if($acl->isAllowed($roleName, $resources))
			{				
				return true;			
			}
		}
		
		return false;
	}
	
	/**
	 * get Acl settings
	 * 
	 * @return Zend_Acl
	 */
	public function getAcl()
	{
		$acl = new Zend_Acl();
		
		
		//define our possible user groups
		$acl->addRole(new Zend_Acl_Role('guest'));
		
		//moderator have at least same access as guest
		$acl->addRole(new Zend_Acl_Role('moderator'), array('guest'));

		$acl->addRole(new Zend_Acl_Role('administrator'));
		
		// define our controllers as resources.
	    $acl->add(new Zend_Acl_Resource('index'));
	    $acl->add(new Zend_Acl_Resource('farmmachinery'));
	    $acl->add(new Zend_Acl_Resource('others'));
	    $acl->add(new Zend_Acl_Resource('planthire'));
	    $acl->add(new Zend_Acl_Resource('telescopichandlers'));
	    $acl->add(new Zend_Acl_Resource('tractors'));
		$acl->add(new Zend_Acl_Resource('moderator'));
		$acl->add(new Zend_Acl_Resource('parts'));
		$acl->add(new Zend_Acl_Resource('administrator'));		
		
		// define our access rules
	    $acl->allow('guest', array('index', 'farmmachinery',
	    						 'others', 'planthire', 'telescopichandlers', 'tractors', 'parts'));
	    $acl->allow('moderator', 'moderator');
		
		 // admins can get to everything
	    $acl->allow('administrator');	    
		
	    
		return $acl;
	}
	
}