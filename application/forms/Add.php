<?php

class Form_Add extends Zend_Form
{

//	private $nPhotos;
//	private $machineType;
		
	public function init()
	{			
		$name = new Zend_Form_Element_Text('name');  
        $name->setLabel('Name');    
        $name->setRequired(true);  
      	$name->addValidator('StringLength', false, array(2,100));  
        
        $yearBuilt = new Zend_Form_Element_Text('yearBuilt');  
        $yearBuilt->setLabel('YearBuilt');    
        //$yearBuilt->setRequired(true);  
        //$yearBuilt->addValidator('Alnum',true);	//zmienic ze moga byc liczby i litery
        $yearBuilt->addValidator('StringLength', false, array(4));  
        $yearBuilt->addFilter('StringTrim');
        
        $hours = new Zend_Form_Element_Text('hours');  
        $hours->setLabel('Hours');    
        //$hours->setRequired(true);  
        $hours->addValidator('StringLength', false, array(1,11));  
        $hours->addFilter('StringTrim');        
        
        $price = new Zend_Form_Element_Text('price');  
        $price->setLabel('Price');    
        $price->setRequired(true);  
        $price->addValidator('StringLength', false, array(1,25));  
        $price->addFilter('StringTrim');       
        
        $description = new Zend_Form_Element_Text('description');  
        $description->setLabel('Description');    
        //$description->setRequired(true);  
        //$description->addValidator('StringLength', false, array(1,300));  
        $description->addFilter('StringTrim');               
        	
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Save');

         $this->addElements(array($name, $yearBuilt, $hours,  $price,
         						 $description, $submit));
        						 
        						    						 
		//We want to display a 'failed authentication' message if necessary;
        // we'll do that with the form 'description', so we need to add that
        // decorator.
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));        			
		
	}
	
}

?>