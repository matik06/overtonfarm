<?php

class Form_MachineDetails extends Zend_Form
{
	protected $name;
	protected $yearBuilt;
	protected $hours;
	protected $price;
	protected $description;
	protected $submit;
	
	
	
	public function init()
	{							       
		
		$this->initializeComponents();
		
        $this->addElements(array($this->name, $this->yearBuilt, $this->hours, $this->price,
         						 $this->description, $this->submit));       					
	}

	public function initializeComponents()
	{
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
//  		$this->description->addValidator('StringLength', false, array(1,250));  
        $this->description->addFilter('StringTrim');   
        $this->description->setAttrib("class", "machine-description");    

        $this->submit = new Zend_Form_Element_Submit('submit');
        $this->submit->setLabel('Save');
	}	

	public function getMachineName()
	{
		return $this->name;
	}
	
	public function getYearBuilt()
	{
		return $this->yearBuilt;
	}
	
	public function getHours()
	{
		return $this->hours;
	}
	
	public function getPrice()
	{
		return $this->price;
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function getSubmit()
	{
		return $this->submit;
	}
	
}

?>