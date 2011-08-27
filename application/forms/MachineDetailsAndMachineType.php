<?php

class Form_MachineDetailsAndMachineType extends Zend_Form
{		
	protected $machineType;
	protected $name;
	protected $yearBuilt;
	protected $hours;
	protected $price;
	protected $description;
	protected $submit;
	
	
	public function init()
	{		
		$this->setAttrib('enctype', 'multipart/form-data');		

		$this->initializeButtons();
		
		
		
		$this->addElements(
			array(			
				$this->machineType,
				$this->name,
		 		$this->yearBuilt,
		 		$this->hours,
		 		$this->price,
		 		$this->description,
		 		$this->submit
 			));		 		        
       					
	}
	
	protected function initializeButtons() 
	{	
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
			
		$this->name = new Zend_Form_Element_Text('name');  
        $this->name->setLabel('Name');    
        $this->name->setRequired(true);  
      	$this->name->addValidator('StringLength', false, array(2,100));  
      	$this->name->setAttrib("class", "machine-description");
        
        $this->yearBuilt = new Zend_Form_Element_Text('yearBuilt');  
        $this->yearBuilt->setLabel('YearBuilt');    
      	$this->yearBuilt->addValidator('Alnum',true);	//zmienic ze moga byc liczby i litery
        $this->yearBuilt->addValidator('StringLength', false, array(4));  
        $this->yearBuilt->addFilter('StringTrim');
        $this->yearBuilt->setAttrib("class", "machine-description");
        
        $this->hours = new Zend_Form_Element_Text('hours');  
        $this->hours->setLabel('Hours');    
        $this->hours->addValidator('StringLength', false, array(1,11));  
        $this->hours->addFilter('StringTrim');
        $this->hours->setAttrib("class", "machine-description");   
        
        $this->price = new Zend_Form_Element_Text('price');  
        $this->price->setLabel('Price');    
        $this->price->setRequired(true);  
        $this->price->addValidator('StringLength', false, array(1,25));
        $this->price->addFilter('StringTrim');
        $this->price->setAttrib("class", "machine-description");       
        
        $this->description = new Zend_Form_Element_Textarea('description');  
        $this->description->setLabel('Description');    
        $this->description->addFilter('StringTrim');   
        $this->description->setAttrib("class", "machine-description");    

        	
        $this->submit = new Zend_Form_Element_Submit('submit');
        $this->submit->setLabel('Save');		
	}
}