<?php

class Form_SelectMachineType extends Zend_Form
{
	public function init()
	{
		
		
		$MainTypes = Model_Mapper_Machine::getMainTypes();
		$MachineryType = array();
		$MainTypeId=1;
		
		foreach($MainTypes as $i)
		{		
			$SecondaryTypes = Model_Mapper_Machine::getSecondaryTypes($MainTypeId);
			foreach($SecondaryTypes as $j)
			{
				$name = $i->name.' : '.$j->name;
				$Mt[] = $name;
			}
			++$MainTypeId;
		}
		
		$MachineType = new Zend_Form_Element_Select('machineType');
		$MachineType->addMultiOptions($Mt)
			 		->setLabel('Machine Type');
			 		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('ok');
		
		$this->addElements(array($MachineType, $submit));
	}
}

?>