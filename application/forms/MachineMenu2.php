<?php
//forma zawierająca tylko jeden 
class Form_MachineMenu2 extends Zend_Form
{
	public function init()
	{	
		
		$this->setAttrib('enctype', 'multipart/form-data');		
        
       
        $fileupd2 = new Zend_Form_Element_File('fileupd2');
        $fileupd2->setLabel('Second photo of machine');
        $fileupd2->addValidator('count', false, 1);
	 	$fileupd2->setDestination('pictures/');
        $fileupd2->setRequired();
        
        $mainTypeName = new Zend_Form_Element_Hidden('mainTypeName');
        $secondaryTypeName = new Zend_Form_Element_Hidden('secondaryTypeName');       
        $idPicture = new Zend_Form_Element_Hidden('idPicture');        
        $id = new Zend_Form_Element_Hidden('id');
        
			 
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Ok');
			 
		$this->addElements(array($fileupd2, $id, $mainTypeName, $secondaryTypeName, $idPicture, $submit));
	}
}