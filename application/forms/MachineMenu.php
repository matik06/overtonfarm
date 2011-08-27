<?php

class Form_MachineMenu extends Zend_Form
{
	private $machineType;
	private $fileupd1;
	private $fileupd2;
	private $fileupd3;
	private $fileupd4;
	private $fileupd5;
	private $fileupd6;
	private $submit;
	
	
	public function init()
	{
		$this->setAttrib('enctype', 'multipart/form-data');	
		$this->initializeComponents();	
		
			 
		$this->addElements(array($this->machineType, $this->fileupd1, $this->fileupd2,
		 		$this->fileupd3, $this->fileupd4, $this->fileupd5, $this->fileupd6, $this->submit));
	}
	
	public function initializeComponents() {
		
		
		$this->machineType = new Zend_Form_Element_Select('machineType');
		$this->machineType->setLabel('Machine Type');
		$this->machineType->setRequired(true);
		
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
				$this->machineType->addMultiOption($secondaryMachineType->id, $name);
			}
		}			
			
			 
		$this->fileupd1 = new Zend_Form_Element_File('fileupd1');
        $this->fileupd1->setLabel('select first photo');
        $this->fileupd1->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $this->fileupd1->setDestination('pictures/');
       
        $this->fileupd2 = new Zend_Form_Element_File('fileupd2');
        $this->fileupd2->setLabel('select second photo');
        $this->fileupd2->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $this->fileupd2->setDestination('pictures/');
        
        $this->fileupd3 = new Zend_Form_Element_File('fileupd3');
        $this->fileupd3->setLabel('select third photo');
        $this->fileupd3->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');        
        $this->fileupd3->setDestination('pictures/');
        
        $this->fileupd4 = new Zend_Form_Element_File('fileupd4');
        $this->fileupd4->setLabel('select fourth photo');
        $this->fileupd4->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $this->fileupd4->setDestination('pictures/');
        
        $this->fileupd5 = new Zend_Form_Element_File('fileupd5');
        $this->fileupd5->setLabel('select fifth photo');
        $this->fileupd5->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $this->fileupd5->setDestination('pictures/');

        $this->fileupd6 = new Zend_Form_Element_File('fileupd6');
        $this->fileupd6->setLabel('select sixth photo');
        $this->fileupd6->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $this->fileupd6->setDestination('pictures/');   
			 
		$this->submit = new Zend_Form_Element_Submit('submitUploadedPhotos');
		$this->submit->setLabel('Ok');
	}
	
	public function getMachineType() 
	{
		return $this->machineType;
	}
	
}
