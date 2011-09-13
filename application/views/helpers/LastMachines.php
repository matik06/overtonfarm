<?php

class Zend_View_Helper_LastMachines extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function lastMachines($machines)
	{
		$result = array();
		
		foreach($machines as $machine)
		{
			$pictures = $machine->getPictures();
			$picture = $pictures[0];
			
			$idMainType = $machine->getIdMainType();
			$idSecondaryType = $machine->getSecondaryType();
			
			$nameMainType = $machine->getMainTypeNameById($idMainType);
			$nameMainType = strtolower($nameMainType);
			
			$nameMainType = str_replace( ' ', '', $nameMainType ); 
			
			$result[] = '
			    <div class="lastarrivals">
	                    <a href="/'.$nameMainType.'/machines/main/'.$idMainType.'/second/'.$idSecondaryType.'">
	                        <img class="lastarrivals" 
	                        src="'.$picture->getThumbUrl().$picture->getThumbName().'" alt=""/>
	                    </a>	                    
	            </div>';							
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
