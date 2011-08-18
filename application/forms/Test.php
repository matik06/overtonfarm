<?php

class Form_Test extends Zend_Form
{
	
	
	public function init()
	{
		$this->setAttrib('enctype', 'multipart/form-data');
		
		
		$photo = new Zend_Form_Element_File('photo');
        $photo->setLabel('Photo');
        
        $photo->setDestination('pictures/Tractors');
        //$photo->setRequired(true);
        //$photo->addValidator('Count', false, 1);
        //$photo->setMaxFileSize(2 * 1024 * 1024);
        //$photo->addValidator('FilesSize', true, '10MB');
        
        
              
              
              
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('wyslij');

    	$this->addElements(array($photo, $submit));
	}
}