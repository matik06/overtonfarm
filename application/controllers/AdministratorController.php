<?php

class AdministratorController extends Zend_Controller_Action
{
	public function indexAction()
	{		
		$form = $this->getFormTest();
		$form->setAttrib('enctype', 'multipart/form-data');
		//$form->photo->setDestination('/pictures');

		$adapter = $form->photo->getTransferAdapter();                		
        $this->view->form = $form; 
	}
	
	public function indexprocessAction()
	{
		$request = $this->getRequest();
		
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	
            $this->_redirect('administrator/index');
        }
        
	    // Get our form and validate it
        $form = $this->getFormTest();
        if (!$form->isValid($request->getPost())) {
            // Invalid entries
            
            $this->view->form = $form;
            return $this->render('index'); // re-render the adduser form                        
        }
        
        
        echo $form->photo->receive();
        
        
        //$photo = $form->photo->getValue();
        
        //$form->photo->setDestination('/pictures');
        //$adapter = $form->photo->getTransferAdapter();
        //$adapter->setDestination('/pictures');
        //$adapter->addValidator('Size', array('0kB', '100kB')); 
        //$adapter->addValidator('Extension',  array('gif', 'jpg', 'png')); 
	}
	
	
	
	public function getFormTest()
	{
		return new Form_Test(array(
            'action' => '/administrator/indexprocess',
            'method' => 'post',
        ));        
	}
	
	public function adduserAction()
	{
		$this->view->addUserForm = $this->getUserForm();//
	}
	
	public function manageusersAction()
	{
		$User = new Model_User();
		
		$usersForm = $this->getUsersForm();		
		$usersForm->getElement('users')->addMultiOptions($User->fetchAll());		
		$this->view->usersList = $usersForm;
		
		$userDetailForm = $this->getUserForm();
	}
	
	public function getUserForm()
	{
		return new Form_User(array(
            'action' => '/administrator/adduserprocess',
            'method' => 'post',
        ));        
	}
	
	public function adduserprocessAction()
	{
		$request = $this->getRequest();
		
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	
            $this->_redirect('administrator/adduser');
        }
        
	    // Get our form and validate it
        $form = $this->getUserForm();
        if (!$form->isValid($request->getPost())) {
            // Invalid entries
            
            $this->view->addUserForm = $form;
            return $this->render('adduser'); // re-render the adduser form                        
        }
        
        
        //if repeated password is not the same
        if($form->getValue('password') != $form->getValue('passwordRepeat'))
        {        	
        	$form->getElement('passwordRepeat')->addError('Repeated password is not the same');        	
            $this->view->addUserForm = $form;
            return $this->render('adduser'); // re-render the adduser form
        }
        
        
        //add user to database
        $user = new Model_User();
        
        $user->setName($form->getValue('name'));
        $user->setSurname($form->getValue('surname'));
        $user->setTelephone($form->getValue('telephone'));
        $user->setNick($form->getValue('nick'));
        $user->setMail($form->getValue('mail'));
        $user->setSex($form->getValue('sex'));
        $user->setPassword($form->getValue('password'));
        $user->setCreatedDate(Zend_Date::now()->toString());
        
        $user->save();
       
        
        //re-render the adduser page with new adduser form and display short information
        $newform = $this->getUserForm();
        $newform->setDescription('New user ' . $user->getNick() . ' is added to database.');        	
        $this->view->addUserForm = $newform;
        return $this->render('adduser'); // re-render the adduser form
	}
	
	public function getUsersForm()
	{
		return new Form_Users(array(
            'action' => '/administrator/manageusersprocess',
            'method' => 'post',
        ));	
	}
	
	public function manageusersprocessAction()
	{
		$request = $this->getRequest();
		
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	
            $this->_redirect('administrator/manageusers');
        }
        
	    // Get our form and validate it
        $form = $this->getUsersForm();
        $form->isValid($request->getPost());
        
        
		if($form->getElement('delete')->isChecked())
		{
			$idUser = $form->getElement('users')->getValue();
			$user = new Model_User();
			$user = $user->delete($idUser);
			$this->_redirect('administrator/manageusers');
		}      
		else if ($form->getElement('details')->isChecked())
		{
			$idUser = $form->getElement('users')->getValue();
			$user = new Model_User();
			$user = $user->find($idUser);
			
			$userDetails = '<table class="userdetails">
							<tr>
								<td class="udleft">Name</td>	<td>' .$user->getName(). '</td>								
							</tr>
							<tr>
								<td class="udleft">Surname</td>	<td>' .$user->getSurname(). '</td>
							</tr>
							<tr>
								<td class="udleft">Nick</td>	<td>' .$user->getNick(). '</td>
							</tr>
							<tr>
								<td class="udleft">Sex</td>	<td>' .$user->getSex(). '</td>
							</tr>
							<tr>
								<td class="udleft">Telephone</td>	<td>' .$user->getTelephone(). '</td>
							</tr>
							<tr>
								<td class="udleft">Mail</td>	<td>' .$user->getMail(). '</td>
							</tr>
							<tr>
								<td class="udleft">Created date</td>	<td>' .$user->getCreatedDate(). '</td>
							</tr>																												
							</table>';							
						
			$formDetails = $this->getDetailsForm();
			
			$this->view->title = 'User details ('.$user->getNick().')';
			$this->view->form = $userDetails . $formDetails;
            
		}
		else if ($form->getElement('restrictions')->isChecked())
		{			
			$roles = new Model_Role();
			$roles = $roles->fetchAll();
			
			$idUser = $form->getElement('users')->getValue();
			$user = new Model_User();
			$user = $user->find($idUser);
			
			$formRoles = $this->getRolesForm();
			$formRoles->getElement('roles')->setMultiOptions($roles);
			$formRoles->getElement('roles')->setValue($user->getRole());
			
			$this->view->title = 'Roles available for '.$user->getNick();
			$this->view->form = $formRoles;

			
			$formRoles->setAction('/administrator/rolesprocess/user/' . $idUser);
		}
	}
	
	public function getDetailsForm()
	{
		$form = new Zend_Form(array(
            'action' => '/administrator/manageusers',
            'method' => 'post',
        ));
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Back');
        
        $form->addElement($submit);
        return $form;
	}
	
	public function getRolesForm()
	{
		$form = new Form_Roles(array(
            'action' => '/administrator/rolesprocess',
            'method' => 'post',
        ));
        
        return $form;
	}
	
	public function rolesprocessAction()
	{
		$request = $this->getRequest();
		
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	
            $this->_redirect('administrator/manageusers');
        }
        
	    // Get our form and validate it
        $form = $this->getRolesForm();
        $form->isValid($request->getPost());
        
        if($form->getElement('back')->isChecked())
        {
        	$this->_redirect('/administrator/manageusers/');
        }
        else if($form->getElement('save')->isChecked())
        {
        	$Role = new Model_Role();
        	$userId = $this->_getParam('user');
        	$roles = $form->getElement('roles')->getValue();
        	$user = new Model_User();
        	$user = $user->find($userId);
        	
        	//adds new roles for user
        	$rolesToAdd = $this->getRolesToAdd($user, $roles);
        	foreach($rolesToAdd as $row)
        	{
        		$id = $Role->findId($row);        		
        		$user->AddRole($id);
        	}
        	
        	$rolesToRemove = $this->getRolesToRemove($user, $roles);
        	foreach($rolesToRemove as $row)
        	{
        		$id = $Role->findId((string)$row);
        		$user->RemoveRole($id);
        	} 
        	
        	$this->_redirect('/administrator/manageusers/');
        }
	}
	
	public function getRolesToAdd(Model_User $user, $rolelist)
	{
		$userRoles = $user->getRole();
		$result = array();
		
		if($rolelist == null)
		{
			$tab = array();
			return $tab;
		}
		
		foreach($rolelist as $rl)
		{
			$addNewRole = true;
			foreach($userRoles as $ur)
			{
				if($rl == $ur)
				{
					$addNewRole = false;
					break;
				}				
			}
			
			if($addNewRole)
			{
				$result[] = $rl;
			}
		}
		
		return $result;
	}
	
	public function getRolesToRemove(Model_User $user, $rolelist)
	{
		$userRoles = $user->getRole();
		$result = array();
		
		if($rolelist == null)
		{
			$tab = array();
			return $tab;
		}
		
		foreach($userRoles as $ur)
		{
			$remove = true;
			foreach($rolelist as $rl)
			{
				if($ur == $rl)
				{
					$remove = false;
					break;
				}
			}
			
			if($remove)
			{
				$result[] = $ur; 
			}
		}
		
		return $result;
	}
}