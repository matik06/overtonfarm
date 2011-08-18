<?php

class Form_Users extends Zend_Form
{
	public function init()
	{
		$users = new Zend_Form_Element_Select('users');
		$users->setLabel('Users');		
		
		$submit = new Zend_Form_Element_Submit('details');
		$submit->setLabel('Show User Details');
		
		$submit2 = new Zend_Form_Element_Submit('restrictions');
		$submit2->setLabel('Show User Restrictions');
		
		$submit3 = new Zend_Form_Element_Submit('delete');
		$submit3->setLabel('Delete User');
		
		
		$this->addElements(array($users, $submit, $submit2, $submit3));
		
		
		$this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));        		
	}	
}