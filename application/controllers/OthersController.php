<?php

class OthersController extends Model_ManagmentController
{
	public function machinesAction()
	{
		//get main and secondary id
		$main = $this->_getParam('main', 0);
		$secondary = $this->_getParam('second', 0);
		
		$this->view->mainId = $main;
		
		//get all machines belongs to main and secondary type
		$machines = new Model_Machine();
		$machines->setMainType($main);
		$machines->setSecondaryType($secondary);
				
		if($secondary != 0)
		{
			$all = $machines->fetchAll();
			$this->view->allmachines = array($all);
						
			$mach = new Model_Machine();			
			$this->view->title = array($mach->getSecondaryTypeAll($secondary)->name);				
		}
		else
		{
			$all = $machines->fetchAllByMainType();			
			
			$this->view->title = $machines->getSecondaryTypeNamesByMainId($main);
			$this->view->allmachines = $all;
		}
	}
}