<?php

class Form_Roles extends Zend_Form
{
	public function init()
	{
		$roles = new Zend_Form_Element_MultiCheckbox('roles');
		
		$submit = new Zend_Form_Element_Submit('save');
		$submit->setLabel('Save');
		
		$submitBack = new Zend_Form_Element_Submit('back');
		$submitBack->setLabel('Back');
		
		
		$this->setElements(array($roles, $submitBack, $submit));
	}
}