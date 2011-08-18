<?php

class Zend_View_Helper_Machines extends Zend_View_Helper_Abstract
{
	public $view;
	
	//check permission for user
	public function checkRole()
	{		
		$user = Zend_Auth::getInstance()->getIdentity();		
		
		//if user is logged
		if(!$user)	
		{
			return false;
		}
		//if is logged is it administrator or moderator
		else if( Model_ManagmentController::checkPermissionStatic($user->getRole(), 'administrator')
    		 || Model_ManagmentController::checkPermissionStatic($user->getRole(), 'moderator'))
    	{
    		 return true;
    	}
    	//if it is not administrator or moderator
    	else
    	{
    		return false;
    	}    	
	}
	
	/**
	 * return form for deleting machines
	 * @param $id - id machine
	 * @param $mainId - main id machine
	 * @return form
	 */
	public function GetDeleteForm($id, $mainId)
	{	
        return 
        
        '<form method="post" action="/moderator/deletemachineprocess">
        	<input type="submit" value="Delete">
        	<input type="hidden" name="id" value="'.$id.'">        	
        	<input type="hidden" name="mainId" value="'.$mainId.'">
        </form>';        
	}
	    
	
	/**
	 * If user is logged and has administrator or moderator permission 
	 * then we display delete button
	 * 
	 * @param $idMachine
	 * @param $mainId
	 * @return form
	 */
	public function DeleteButton($idMachine, $mainId)
	{
		$deleteOption = $this->checkRole();
		
		if($deleteOption)
		{
			return $this->GetDeleteForm($idMachine, $mainId);
		}
		else
		{
			return '';	
		}
	}
	
	
	/**
	 * Return html code contains machines
	 * @param $machines for displaying
	 * @param $title for machinery
	 * @param $mainId 
	 * @return string with html code
	 */
	public function machines($machines = null, $title, $mainId )
	{		
		$this->deleteOption = $this->checkRole();		
		$result = array();		 
		
		for($i = 0; $i<sizeof($title); $i++)
		{
			//if some title doesn't contains machinery then dont't display for it nothing
			if(sizeof($machines[$i]) == 0)
			{				
				continue;
			}
		
			$result[] = '<div class="title">'.$title[$i].'</div>';
			
			//generate view(html code) for all machines
			foreach($machines[$i] as $machine)
			{
			
				//generate html code for all pictures for single machine
				$pictures = $machine->getPictures();			
				
				$tabPictures = array();
				foreach($pictures as $picture)
				{
					$tabPictures[] = '
					<div class="img">
	                    <a href="'.$picture->getUrl().$picture->getName().'" rel="lightbox-'.$machine->getId().'">
	                        <img class="main" src="'.$picture->getThumbUrl().$picture->getThumbName().
	                        '" alt="" />
	                    </a> 
	                    <div class="click">Click Image to Enlarge</div>
	                </div>';				
				}
				
				//scalanie elementow tablicy do 1 stringa
				$allPictures = implode('', $tabPictures);
				
				
				//generate html code for single machine with all information			
				$result[] = '
				<div class="content">
	            
	                '.$allPictures.'                
	                
	                <div class="left">
	                    Model<br />
	                    <br />
	                    Year<br />';
				
				if($machine->getHours() != '')
				{
					$result[] = 'Hour<br />';
				}
	            
	            $result[] = '	                    
	                    Price<br />
	                    <br />
	                    Description<br />';
				
	            $result[] = $this->DeleteButton($machine->getId(), $mainId);
	                
				$result[] = '
	                </div>
	                <div class="right">
	                    '.$machine->getName().'<br />
	                    <br />
	
	                    '.$machine->getYearBuilt().'<br />';
				
				if($machine->getHours() != '')
				{
					$result[] = $machine->getHours().'<br />';
				}
	                    
	                    
				$result[] ='	                    
	                    £ '.$machine->getPrice().'<br />
	                    <br />
	                    '.$machine->getDescription().'                
	                </div>               
	            </div> 
	            
				';			
			}
		}
		
		//scalanie elementow tablicy do 1 stringa
		$wynik = implode('', $result);		
		return $wynik;
	}
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
}