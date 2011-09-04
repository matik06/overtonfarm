<?php

class Form_EditMachinePhotos extends Zend_Form
{	
	const EMPTY_IMAGE_PATH = "/images/empty.jpg";	
	
	private $fileupd1;
	private $originFile1;
	private $img1;
	
	private $fileupd2;
	private $originFile2;
	private $img2;
	
	private $fileupd3;
	private $originFile3;
	private $img3;
	
	private $fileupd4;
	private $originFile4;
	private $img4;
	
	private $fileupd5;
	private $originFile5;
	private $img5;
	
	private $fileupd6;
	private $originFile6;
	private $img6;
	
	private $machineId;
	private $submit;
	
	public function init()
	{
		$this->setAttrib('enctype', 'multipart/form-data');	
		$this->initializeComponents();		
					 
		$this->addElements(array($this->img1, $this->img2, $this->fileupd1, $this->fileupd2,
					$this->img3, $this->img4, $this->fileupd3, $this->fileupd4,
					$this->img5, $this->img6, $this->fileupd5, $this->fileupd6,
				 	$this->submit, $this->machineId, $this->originFile1, $this->originFile2, $this->originFile3, $this->originFile4, $this->originFile5, $this->originFile6));
	}
	
	private function initializeComponents()
	{
		
		
		$this->fileupd1 = new Zend_Form_Element_File('fileupd1');
        $this->fileupd1->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg')
        			->addValidator('Size', false, array('max' => 5242880))
        			->setDestination('pictures/')
        			->setAttrib("class", "edit-photos")
        			->setDecorators(array('File'));
        			        			        					        		        			
       
        $this->fileupd2 = new Zend_Form_Element_File('fileupd2');
        $this->fileupd2->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg')
        			->addValidator('Size', false, array('max' => 5242880))
        			->setDestination('pictures/')
        			->setAttrib("class", "edit-photos")
        			->setDecorators(array('File'));

        $this->fileupd3 = new Zend_Form_Element_File('fileupd3');
        $this->fileupd3->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg')
        			->addValidator('Size', false, array('max' => 5242880))
        			->setDestination('pictures/')
        			->setAttrib("class", "edit-photos")
        			->setDecorators(array('File'));        
        			
        $this->fileupd4 = new Zend_Form_Element_File('fileupd4');
        $this->fileupd4->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg')
        			->addValidator('Size', false, array('max' => 5242880))
        			->setDestination('pictures/')
        			->setAttrib("class", "edit-photos")
        			->setDecorators(array('File'));        
        			
        $this->fileupd5 = new Zend_Form_Element_File('fileupd5');
        $this->fileupd5->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg')
        			->addValidator('Size', false, array('max' => 5242880))
        			->setDestination('pictures/')
        			->setAttrib("class", "edit-photos")
        			->setDecorators(array('File'));        
        			
        $this->fileupd6 = new Zend_Form_Element_File('fileupd6');
        $this->fileupd6->addValidator('count', false, 1)
        			->addValidator('Extension', false, 'jpg,png,gif,jpeg')
        			->addValidator('Size', false, array('max' => 5242880))
        			->setDestination('pictures/')
        			->setAttrib("class", "edit-photos")
        			->setDecorators(array('File'));        			
        			
        $this->originFile1 = new Zend_Form_Element_Hidden("originFile1");
        $this->originFile1->setDecorators(array('ViewHelper'));
        
        
        $this->originFile2 = new Zend_Form_Element_Hidden("originFile2");
        $this->originFile2->setDecorators(array('ViewHelper'));
        
        $this->originFile3 = new Zend_Form_Element_Hidden("originFile3");
        $this->originFile3->setDecorators(array('ViewHelper'));
        
        $this->originFile4 = new Zend_Form_Element_Hidden("originFile4");
        $this->originFile4->setDecorators(array('ViewHelper'));
        
        $this->originFile5 = new Zend_Form_Element_Hidden("originFile5");
        $this->originFile5->setDecorators(array('ViewHelper'));
        
        $this->originFile6 = new Zend_Form_Element_Hidden("originFile6");
        $this->originFile6->setDecorators(array('ViewHelper'));
        
		$this->machineId = new Zend_Form_Element_Hidden("machineId");
        $this->machineId->setDecorators(array('ViewHelper'));
        
        $this->img1 = new Zend_Form_Element_Image("img1");
		$this->img1->setImage(self::EMPTY_IMAGE_PATH)
			->setDecorators(array('Image'))
			->setAttrib("class", "img1");			
		
		$this->img2 = new Zend_Form_Element_Image("img2");
		$this->img2->setImage(self::EMPTY_IMAGE_PATH)
			->setDecorators(array('Image'))
			->setAttrib("class", "img2");
			
		$this->img3 = new Zend_Form_Element_Image("img3");
		$this->img3->setImage(self::EMPTY_IMAGE_PATH)
			->setDecorators(array('Image'))
			->setAttrib("class", "img1");
			
		$this->img4 = new Zend_Form_Element_Image("img4");
		$this->img4->setImage(self::EMPTY_IMAGE_PATH)
			->setDecorators(array('Image'))
			->setAttrib("class", "img2");
			
		$this->img5 = new Zend_Form_Element_Image("img5");
		$this->img5->setImage(self::EMPTY_IMAGE_PATH)
			->setDecorators(array('Image'))
			->setAttrib("class", "img1");
			
		$this->img6 = new Zend_Form_Element_Image("img6");
		$this->img6->setImage(self::EMPTY_IMAGE_PATH)
			->setDecorators(array('Image'))
			->setAttrib("class", "img2");
			
        			
        $this->submit = new Zend_Form_Element_Submit('submitUploadedPhotos');
		$this->submit->setLabel('Upload New Photos')
			->setAttrib("style", "margin-left:-40px;");
	}
}