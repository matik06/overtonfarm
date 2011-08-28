<?php

class ModeratorController extends Model_ManagmentController 
{
	//size of scaled photo
	const PHOTO_WIDTH = 640;
	const PHOTO_HEIGHT = 480;
	
	//size of scaled thumbnail
	const THUMBNAIL_WIDTH = 133;
	const THUMBNAIL_HEIGHT = 100;
	
	//path to main directory with uploaded photos
	const MAIN_PHOTO_URL = "pictures/";
	
	
	public function indexAction()
	{
		
	}
	
	public function getMachineTypeForm()
	{
		return new Form_MachineMenu(array(
            'action' => '/moderator/addmachineprocess1',
            'method' => 'post',
        ));
	}
	
	public function getMachineDetailsAndMachineType() {
		return new Form_MachineDetailsAndMachineType(array(
		 	'action' => '/moderator/updatemachineprocess',
            'method' => 'post',
		));
	}
	
	public function addmachineAction()
	{
		$this->view->form = $this->getMachineTypeForm();
		
		$session = Zend_Registry::get('session');
		$session->uploadedPhotoCount = 0;
      	$session->test = array();

		
		$machinee = new Model_Machine();      
	}

	public function addmachineprocess1Action()
	{
		
		$request = $this->getRequest();
		
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	
            $this->_redirect('moderator/addmachine');
        }
        
         // Get our form and validate it
        $form = $this->getMachineTypeForm();
        
        //check validation        									
        if (!$form->isValid($request->getPost())) 
        {
            // Invalid entries
            $this->view->form = $form;
            return $this->render('addmachine'); // re-render the adduser form                        
        }        
        
        $machineType =  $form->getElement('machineType')->getUnfilteredValue();
             	     	
      	$session = Zend_Registry::get('session');
      	$session->machineType = $machineType;
      	      	      
     	$form = $this->getMachineDescriptionForm("addmachineprocess2");     	     	     
      	$this->view->form = $form;      	      	
	}
	
	
	
	
	//set displayed first two photos (if empty set default photo)
	private function setMainPhotos($photo, $machineType, $photoId)
	{
	    if ($photo == null)
      	{
      		$photoUtil = new Model_PhotoUtil();
      		
      		$destination = self::MAIN_PHOTO_URL.Model_PhotoUtil::DEFAULT_PHOTO_NAME;
      		$photoUtil->copyDefaultPhoto($destination);
      		$this->savePhoto(Model_PhotoUtil::DEFAULT_PHOTO_NAME, $machineType, $photoId);
      	} else 
      	{
      		$this->savePhoto($photo, $machineType, $photoId);	
      	}
	}
	
	//scale and save photo in correct directory
	private function savePhoto($photoName, $machineType, $photoId)
	{		
			$machie = new Model_Machine();
			//pobranie nazwy głównego typu (tractors, ...)
	      	$mainTypeName = $machie->getMainTypeAll($machineType)->name;
	      	//pobranie nazwy podtypu (Case IH, ...)
	      	$secondaryTypeName = $machie->getSecondaryTypeAll($machineType)->name;
	      	
	      	//adres uploadowanego zdjęcia (domyślnie: pictures/nazwa_pliku)
	      	$urlTmpPicture = self::MAIN_PHOTO_URL.$photoName;
	
	      	//ścieżki dla zdjęć oraz ich miniaturek
	      	$url = self::MAIN_PHOTO_URL.$mainTypeName.'/'.$secondaryTypeName.'/';
	      	$urlThumb = self::MAIN_PHOTO_URL.$mainTypeName.'/'.$secondaryTypeName.'/thumbs/';
	
	      	//skalowanie zdjęć
	      	$photoUtil = new Model_PhotoUtil();
	      	$photoUtil->resampimagejpg(self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT, $urlTmpPicture, $urlThumb.$photoId.'.jpg');
	      	$photoUtil->resampimagejpg(self::PHOTO_WIDTH, self::PHOTO_HEIGHT, $urlTmpPicture, $url.$photoId.'.jpg');
	}
	
	public function addmachineprocess2Action()
	{
		$request = $this->getRequest();
		
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	
            $this->_redirect('/moderator/addmachine');
        }
        
         // Get our form and validate it
        $form = $this->getMachineDescriptionForm("addmachineprocess2");
        
        //check validation        									
        if (!$form->isValid($request->getPost())) 
        {
            // Invalid entries
            $this->view->form = $form;
            return $this->render('addmachineprocess1'); // re-render the adduser form                        
        }
        
        
        $machinee = new Model_Machine();        
        $session = Zend_Registry::get('session');        
		$machineType = $session->machineType;		   
		
      	$MainType = $machinee->getMainTypeAll($machineType);	//typ główny maszyny
      	$SecondaryType = $machinee->getSecondaryTypeAll($machineType);	//podtyp maszyny      	         	
      	$url = self::MAIN_PHOTO_URL.$MainType->name.'/'.$SecondaryType->name.'/';
      	
      	      	
        $photoUtil = new Model_PhotoUtil();             	 
      	//pobranie id ostatniego zdjęcia      	
      	$photoId = Model_Mapper_Picture::getLastId();
		      	      	      	

      	$totalPhotoCouter = 0;
      	if($session->uploadedPhotoCount == 0)	//użytkownik nie wybrał żadnego zdjęcia
      	{
      		$this->setMainPhotos(null, $machineType, $photoId);
      		$photoId++;
      		$this->setMainPhotos(null, $machineType, $photoId);
      		$photoId++;
      		$totalPhotoCouter = 2;
      	} 
      	else if( $session->uploadedPhotoCount == 1 )	//użytkownik wybrał 1 zdjęcie
      	{      		
      		
      		$photo = $session->test[0];
	
	      	$this->savePhoto($photo, $machineType, $photoId);
	      	$photoId++;      			      			
	      	$this->setMainPhotos(null, $machineType, $photoId);
      		$photoId++;
      		$totalPhotoCouter = 2;
      	}
      	else	//użytkownik wybrał 2 lub więcej zdjęć
      	{
      	    for ($i = 0; $i < $session->uploadedPhotoCount; $i++) 
	      	{
	      		$photo = $session->test[$i];
	
	      		$this->savePhoto($photo, $machineType, $photoId);
	      		$photoId++;      			      			      			
	      	}
	      	$totalPhotoCouter = $session->uploadedPhotoCount;
      	}
      	      	      	
      	//usuwanie oryginalnych zdjęć
      	for($i = 0; $i < $session->uploadedPhotoCount; $i++) 
      	{
      		$photo = $session->test[$i];
      			$urlTmpPicture = self::MAIN_PHOTO_URL.$photo;
		    	unlink($urlTmpPicture);
      	}      	      	      	
      	
      	      	      	
		$pictures = $this->getPhotos($totalPhotoCouter, $url);      	      	
      	$machine = new Model_Machine();
      	
      	$machine->setCondition('default');
      	$machine->setDescription($form->getElement('description')->getValue());
      	
      	$machine->setIdUser(Zend_Auth::getInstance()->getIdentity()->getId());
      	$machine->setHours($form->getElement('hours')->getValue());
      	$machine->setName($form->getElement('name')->getValue());
      	$machine->setPrice($form->getElement('price')->getValue());
      	$machine->setYearBuilt($form->getElement('yearBuilt')->getValue());
        $machine->setMainType($MainType->id);
      	$machine->setSecondaryType($SecondaryType->id);
      	
      	
        $machine->setPictures($pictures);
        
        
        
        $machine->save();
      	
        $this->_redirect('/moderator/addmachine/');
	}
	
	//wstawia do bazy ścieżki + nazwy zdjęć maszyn
	public function getPhotos($photoCount, $url)
	{
		$nextPhotoId = Model_Mapper_Picture::getLastId();
		$pictures = array();		      	
		
      	for($i = 0; $i < $photoCount; $i++)
      	{
      		$picture = new Model_Picture();
      		
      		$picture->setName($nextPhotoId.'.jpg');
      		$picture->setThumbName($nextPhotoId.'.jpg');
      		$nextPhotoId++;
      		$picture->setUrl('/'.$url);
      		$picture->setThumbUrl('/'.$url.'thumbs/');
      		$picture->setOrder($i);
      		
      		$pictures[] = $picture;
      	}
      	
      	return $pictures;
	}
	
	public function editmachinesAction()
	{
	  $this->view->title = "Machines";
  	  $machine = new Model_Machine();
   	  $this->view->machines = $album->fetchAll(); 
	}
	
	public function youraccountAction()
	{		
		//get actual logged user
		$user = Zend_Auth::getInstance()->getIdentity();		
		$form = $this->getUserForm();
		
		//get all form elements (we need fill that elements with user details)
		$elements = $form->getElements();
		
		//filling form elements
		$form->setElements(array(
				$elements['name']->setValue($user->getName()),
				$elements['surname']->setValue($user->getSurname()),
				$elements['telephone']->setValue($user->getTelephone()),
				$elements['nick']->setValue($user->getNick()),
				$elements['mail']->setValue($user->getMail()),		
				$elements['password']->setLabel('New Password')
									 ->setRequired(false),
				$elements['passwordRepeat']->setLabel('New Password (repeat)')
										   ->setRequired(false),
				$elements['sex']->setValue($user->getSex()),
				$elements['submit']->setLabel('Save Changes'),
		));
		
		//set view with created form
		$this->view->form = $form;
	}
	
	public function youraccountprocessAction()
	{
		$request = $this->getRequest();
		
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	
            $this->_redirect('moderator/youraccount');
        }
        
        
	    // Get our form and validate it
        $form = $this->getUserForm();
        
        //set password and passwordRequired element on false
        $form->getElement('password')->setRequired(false)
        							->setLabel('New Password');
        $form->getElement('passwordRepeat')->setRequired(false)
        									->setLabel('New Password (repeat)');
        
		//check validation        									
        if (!$form->isValid($request->getPost())) 
        {
            // Invalid entries
            
            $this->view->form = $form;
            return $this->render('youraccount'); // re-render the adduser form                        
        }
        
        //get curent logged user
		$user = Zend_Auth::getInstance()->getIdentity();
        
        $password = $form->getElement('password')->getValue();
		$passwordRepeat = $form->getElement('passwordRepeat')->getValue();
		
        //if user fill password element
        if( $password != null ||  $passwordRepeat!= null )
        {
  	        //check password and passwordRepeat is the same
  	        if( $password != $passwordRepeat )
  	        {
  	        	$form->getElement('passwordRepeat')->addError('Repeated password is incorect');
        		$this->view->form = $form;
            	return $this->render('youraccount'); // re-render the adduser form
  	        }
  	        
  	        $user->setPassword($form->getElement('password')->getValue());
        }               	

        //update user information from FormUser
        $user->setName($form->getElement('name')->getValue());
        $user->setSurname($form->getElement('surname')->getValue());
        $user->setTelephone($form->getElement('telephone')->getValue());
        $user->setNick($form->getElement('nick')->getValue());
        $user->setMail($form->getElement('mail')->getValue());
        $user->setSex($form->getElement('sex')->getValue());
        $user->save();
        
        
        $this->_redirect('/moderator/youraccount');
	}
	
	public function getUserForm()
	{
		return new Form_User(array(
            'action' => '/moderator/youraccountprocess',
            'method' => 'post',
        ));        
	}
	

	 
	public function getMachineDescriptionForm($controllerMethodName)
	{
		return new Form_MachineDetails(array(
            'action' => '/moderator/'.$controllerMethodName,
            'method' => 'post',
        ));
        
	}
		

	/**
	 * Delete choosen machine and redirect user back to the same place
	 * 
	 * @return nothing
	 */
	public function deletemachineprocessAction()
	{
		$request = $this->getRequest();

		//generate last url
		$mainId = $_POST['mainId'];
        $lastURL = $this->getLastUrl($mainId);	
		
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	
            $this->_redirect('/index/index/');
        }

        //delete machine
        $machine = new Model_Machine();
        $machine->delete($_POST["id"]);
        
                
        $this->_redirect($lastURL);        
	}


	/**
	 * 
	 * display form with machiene datails
	 */
	public function editmachineprocessAction()
	{
		$request = $this->getRequest();
		           	     	        	
        $mainId = $_POST['mainId'];
        $lastURL = $this->getLastUrl($mainId);	
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	        
            $this->_redirect($lastURL);
        }
        
        $machine = new Model_Machine();
        
        //get machine by id 
        $machineId = $_POST["id"];
        $machine = $machine->getMachineById($machineId);   

        //save machine and last url address in session
        $session = Zend_Registry::get('session');
      	$session->machine = $machine;
      	$session->lastURL = $lastURL;      	
        
        //create and fill form with machine details
        $form = $this->getMachineDetailsAndMachineType();
        $form->getElement("machineType")->setValue($machine->getSecondaryType());        
        $form->getElement("name")->setValue($machine->getName());
        $form->getElement("yearBuilt")->setValue($machine->getYearBuilt());
        $form->getElement("hours")->setValue($machine->getHours());
        $form->getElement("price")->setValue($machine->getPrice());
        $form->getElement("description")->setValue($machine->getDescription());        
        
      	$this->view->form = $form;      	                
	}
	
	/**
	 * 
	 * Enter Update machine details and redirect back
	 */
	public function updatemachineprocessAction()
	{				
		$request = $this->getRequest();
		
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	
            $this->_redirect('/moderator/addmachine');
        }
        
         // Get our form and validate it
        $form = $this->getMachineDetailsAndMachineType(); 
        
        //check validation        									
        if (!$form->isValid($request->getPost())) 
        {
            // Invalid entries
            $this->view->form = $form;
            return $this->render('updatemachineprocess'); // re-render the adduser form                        
        }

        //get machine from session
        $session = Zend_Registry::get('session');        
		$machine = $session->machine;		
      	
		//update machine with modifications from form
      	$machine->setDescription($form->getElement('description')->getValue());      	
      	$machine->setHours($form->getElement('hours')->getValue());
      	$machine->setName($form->getElement('name')->getValue());
      	$machine->setPrice($form->getElement('price')->getValue());
      	$machine->setYearBuilt($form->getElement('yearBuilt')->getValue()); 
      	$machine->setSecondaryType($form->getElement("machineType")->getValue());               
      	
        $machine->save();
      	
        $lastUrl = $session->lastURL;
        $this->_redirect($lastUrl);
	}
	
	public function swapphotosprocessAction() 
	{
		$request = $this->getRequest();
		           	     	        	
        $mainId = $_POST['mainId'];
        $lastURL = $this->getLastUrl($mainId);
        	
	    //Check if we have a POST request
        if (!$request->isPost()) 
        {        	        
            $this->_redirect($lastURL);
        }
        
        $machine = new Model_Machine();
        
        
        //get machine by id 
        $machineId = $_POST["id"];
        $machine = $machine->getMachineById($machineId);

        $machinePictures = $machine->getPictures();
        $picture1 = $machinePictures[0];
        $picture2 = $machinePictures[1];
        
        $temp = $picture1->getOrder();
		$picture1->setOrder($picture2->getOrder());
		$picture2->setOrder($temp);		
		
		$picture1->update();
		$picture2->update();


        $this->_redirect($lastURL);
	}	
	
	/**
	 * 
	 * generate last url addres from id machine main type
	 * used in buttons: edit description, delete
	 * 
	 * @param $mainIdType
	 */	
	private function getLastUrl($mainIdType)
	{
		//get name of machine main type
		$machine = new Model_Machine();
		$mainType = $machine->getMainTypeNameById($mainIdType);
		$mainType = strtolower($mainType);
		
		//chiecking is type is 2-words seperated by space
        $space = strpos($mainType, " ");
		
        //removes white spaces it name contains more words
        if($space != '')
        {        	
    		$first = substr($mainType, 0, $space);
			$second = substr($mainType, $space+1);

			$mainType = $first.$second;
        }
	        
        return $mainType.'/machines/main/'.$mainIdType.'/secondary/0/';
	}
	
	public function uploadpicturesAction()
	{
		$request = $this->getRequest();
		
	 	if (!$request->isPost()) 
        {        	
            $this->_redirect('/moderator/addmachine');
        }
		
		$session = Zend_Registry::get('session');
		$session->uploadedPhotoCount = $session->uploadedPhotoCount+1;
      	$session->test[] = $_REQUEST["filaName"];
	}
	
}