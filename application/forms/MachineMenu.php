<?php

class Form_MachineMenu extends Zend_Form
{
	public function init()
	{	

		$this->setAttrib('enctype', 'multipart/form-data');	
		
		$MachineType = new Zend_Form_Element_Select('machineType');
		$MachineType->setLabel('Machine Type');
		$MachineType->setRequired(true);
		
		//pobranie typów głównych
		$MTypes = Model_Mapper_Machine::getMainTypes();		
		
		foreach($MTypes as $mainMachineType)
		{		
			//pobranie podtypów dla typu głównego
			$idMainType = $mainMachineType->id;
			$STypes = Model_Mapper_Machine::getSecondaryTypes($idMainType);
			foreach($STypes as $secondaryMachineType)
			{
				//label składający się z typu głównego oraz podtypu
				$name = $mainMachineType->name.' : '.$secondaryMachineType->name;
				$MachineType->addMultiOption($secondaryMachineType->id, $name);
			}
		}			
			
			 
		$fileupd1 = new Zend_Form_Element_File('fileupd1');
        $fileupd1->setLabel('select first photo');
        $fileupd1->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $fileupd1->setDestination('pictures/');
       
        $fileupd2 = new Zend_Form_Element_File('fileupd2');
        $fileupd2->setLabel('select second photo');
        $fileupd2->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $fileupd2->setDestination('pictures/');
        $fileupd2->setAttrib('disabled', 'disabled');
        
        $fileupd3 = new Zend_Form_Element_File('fileupd3');
        $fileupd3->setLabel('select third photo');
        $fileupd3->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');        
        $fileupd3->setDestination('pictures/');
        $fileupd3->setAttrib('disabled', 'disabled');
        
        $fileupd4 = new Zend_Form_Element_File('fileupd4');
        $fileupd4->setLabel('select fourth photo');
        $fileupd4->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $fileupd4->setDestination('pictures/');
        $fileupd4->setAttrib('disabled', 'disabled');
        
        $fileupd5 = new Zend_Form_Element_File('fileupd5');
        $fileupd5->setLabel('select fifth photo');
        $fileupd5->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $fileupd5->setDestination('pictures/');
        $fileupd5->setAttrib('disabled', 'disabled');

        $fileupd6 = new Zend_Form_Element_File('fileupd6');
        $fileupd6->setLabel('select sixth photo');
        $fileupd6->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $fileupd6->setDestination('pictures/');   
        $fileupd6->setAttrib('disabled', 'disabled');
			 
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Ok');
			 
		$this->addElements(array($MachineType, $fileupd1, $fileupd2, $fileupd3, $fileupd4, $fileupd5, $fileupd6, $submit));
	}
}
