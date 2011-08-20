<?php

/**
 * Index controller
 *
 * Default controller for this application.
 * 
 * @uses       Zend_Controller_Action
 * @package    QuickStart
 * @subpackage Controller
 */
class IndexController extends Zend_Controller_Action
{
	public function galeryAction()
	{
	
	}


	public function ketlecAction()
	{

	}
	
    public function indexAction()
    {
    	
        $machine = new Model_Machine();	        
        $this->view->lm = $machine->GetLastMachines(7);   
    }
    
	public function contactusAction()
    {
        
    }
    
    public function nopermissionAction()
    {
    	
    }
    
	public function loginAction()
	{	
		if(Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_redirect('/index/index');
		}
		{
			$this->view->form = $this->getForm();
				
		}	
				
	}
	
	public function getForm()
	{
		return new Form_Login(array(
            'action' => '/index/process',
            'method' => 'post',
        ));
	}
	
	public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/index/index'); 
    }
    
    public function processAction()
    {
    	$request = $this->getRequest();
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {       	
        	return $this->_helper->redirector('login');
            //$this->_redirect('administrator/index');	//to samo co wyzej
        }
        
	    // Get our form and validate it
        $form = $this->getForm();
        if (!$form->isValid($request->getPost())) {
            // Invalid entries
            $this->view->form = $form;
            return $this->render('login'); // re-render the login form
        }
        
        //get authenticate information
        $nick = $form->getValue('nickname');
        $password = $form->getValue('password');
        
        $auth = Zend_Auth::getInstance();
		$adapter = new Model_AuthAdapter($nick, $password);
		$result = $auth->authenticate($adapter);
				
        
        if(!$result->isValid())
        {
        	$messages =  $result->getMessages();
        	$form->getElement('password')->addError($messages[0]);
        	//$form->setDescription();
            $this->view->form = $form;
            return $this->render('login'); // re-render the login form
        }
        else
        {
        	$this->_redirect('/index/index');        	 
        }
        
    }
    

}