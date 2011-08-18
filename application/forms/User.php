<?php

class Form_User extends Zend_Form
{
	public function init()
	{
        
        $name = new Zend_Form_Element_Text('name');  
        $name->setLabel('Name');    
        $name->setRequired(true);  
        $name->addValidator('Alnum', true);
        $name->addValidator('StringLength', false, array(2, 30));  
        $name->addFilter('StringTrim');
        
        $surname = new Zend_Form_Element_Text('surname');  
        $surname->setLabel('Surame');    
        $surname->setRequired(true);  
        $surname->addValidator('Alnum', true);
        $surname->addValidator('StringLength', false, array(3, 35));  
        $surname->addFilter('StringTrim');
        
        $telephone = new Zend_Form_Element_Text('telephone');  
        $telephone->setLabel('Telephone');    
        //$telephone->setRequired(true);        
        $telephone->addValidator('StringLength', false, array(7, 30));  
        $telephone->addFilter('StringTrim');
        
        $nick = new Zend_Form_Element_Text('nick');  
        $nick->setLabel('Nick');    
        $nick->setRequired(true);  
        $nick->addValidator('Alnum', true);
        $nick->addValidator('StringLength', false, array(3, 20));  
        $nick->addFilter('StringTrim');
        $nick->addFilter('StringToLower');  
        
        $mail = new Zend_Form_Element_Text('mail');  
        $mail->setLabel('Mail');    
        //$mail->setRequired(true);  
        $mail->addValidator('EmailAddress', true);  
        $mail->addFilter('StringTrim');
        
        $password = new Zend_Form_Element_Password('password');  
        $password->setLabel('Password');    
        $password->setRequired(true);  
        $password->addValidator('StringLength', false, array(6, 20)); 
        $password->addFilter('StringTrim');
        
        $passwordRepeat = new Zend_Form_Element_Password('passwordRepeat');  
        $passwordRepeat->setLabel('Password (repeat)');    
        $passwordRepeat->setRequired(true);  
        $passwordRepeat->addValidator('StringLength', false, array(6, 20));  
        $passwordRepeat->addFilter('StringTrim');
        
        $sex = new Zend_Form_Element_Radio('sex');
        $sex->setLabel('Sex');
        $sex->setRequired(true);
        $sex->addMultiOption('male', 'male');
        $sex->addMultiOption('female', 'female');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Save');
        
        
        $this->addElements(array($name, $surname, $telephone, $nick,  $mail,
        						 $password, $passwordRepeat, $sex, $submit,));
        						 
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
