<?php  
class Model_Mapper_Machine
{
	protected $db;
	
	/**
	 * Set connection to database
	 * 
	 * @return Model_Mapper_Role
	 */
    public function setDb()
    {
        if (null === $this->db)
        {
           $this->db = Zend_Registry::get('db');
           $this->db->setFetchMode(Zend_Db::FETCH_OBJ);           
        }       
        
        return $this;
    }
	
    /**
     *get instance connection to database
     * 
     * @return Model_Mapper_Machine
     */
    public function getDb()
    {
        if (null === $this->db) 
        {
            $this->setDb();
        }
        return $this->db;
    }
	
  /**
     * Fetch all machines by main and secondary type
     * 
     * @return array
     */
    public function fetchAll($mainType , $secondaryType)
    {    
    			
   		$sql = 'SELECT * FROM Machines 
    		WHERE (idSecondaryType='.(int)$secondaryType.')AND(idMainType='.(int)$mainType.')
    		ORDER BY id DESC' ;
    	 
    			
    		
    	$this->getDb()->setFetchMode(Zend_Db::FETCH_OBJ);    	
        $resultSet = $this->getDb()->fetchAll($sql);
        
        //array to store all machines
        $entries   = array();   
        foreach ($resultSet as $row)  
        {
        	$pict = new Model_Picture();
        	$pict->setMachineId($row->id);
        	$arraypict = $pict->fetchAll();
            $entry = new Model_Machine();
            $entry->setId($row->id)  
            	  ->setIdUser($row->idUser)
            	  ->setMainType($row->idMainType)
            	  ->setSecondaryType($row->idSecondaryType)           	
                  ->setName($row->name)
                  ->setYearBuilt($row->yearBuilt)
                  ->setDescription($row->description)  
                  ->setPrice($row->price)
                  ->setHours($row->hours)
                  ->setCondition($row->condition)
                  ->setDayOfEntry($row->dayOfEntry)    
                  ->setPictures($arraypict)                              
                  ->setMapper($this);    
            //add machine to array
            $entries[] = $entry;            
        }
        return $entries;        
    }
    
    /**
     * return Model_Machine object by id
     * 
     * @param $id
     */
    public function getMachineById($id)
    {
    
    	$sql = 'SELECT * FROM Machines	    			
    			WHERE id = '.$id;
    			   			    	
        $queryResult = $this->getDb()->fetchAll($sql);        
        $machine = new Model_Machine();        
        $pict = new Model_Picture();        

        foreach ($queryResult as $row)
        {
        	$pict->setMachineId($row->id);
        	$arraypict = $pict->fetchAll();
        	
       		$machine->setId($row->id)  
        		    ->setIdUser($row->idUser)
           	  		->setMainType($row->idMainType)
           	  		->setSecondaryType($row->idSecondaryType)           	
              		->setName($row->name)
              		->setYearBuilt($row->yearBuilt)
              		->setDescription($row->description)  
              		->setPrice($row->price)
              		->setHours($row->hours)
              		->setCondition($row->condition)
              		->setDayOfEntry($row->dayOfEntry)    
              		->setPictures($arraypict)                              
              		->setMapper($this); 
        }
                                                     
        return $machine;
    }
    
    
 /**
     * Fetch all machines entries by main id
     * 
     * @return array
     */
    public function fetchAllByMainType($mainType)
    {    

    	$secondaryTypeId = $this->getSecondaryTypeIdByMainId($mainType);
    	$mainResult = array();    	
    	
    	foreach($secondaryTypeId as $sti)
    	{    		   	
	   		$sql = 'SELECT * FROM Machines 
	    			WHERE idSecondaryType ='.(int)$sti.'
	    			ORDER BY id DESC';
	    	     	
	        $resultSet = $this->getDb()->fetchAll($sql);
	        
	        //array to store all machines
	        $entries   = array();   
	        foreach ($resultSet as $row)  
	        {	        	
	        	$pict = new Model_Picture();
	        	$pict->setMachineId($row->id);
	        	$arraypict = $pict->fetchAll();
	            $entry = new Model_Machine();
	            $entry->setId($row->id)  
	            	  ->setIdUser($row->idUser)
	            	  ->setMainType($row->idMainType)
	            	  ->setSecondaryType($row->idSecondaryType)           	
	                  ->setName($row->name)
	                  ->setYearBuilt($row->yearBuilt)
	                  ->setDescription($row->description)  
	                  ->setPrice($row->price)
	                  ->setHours($row->hours)
	                  ->setCondition($row->condition)
	                  ->setDayOfEntry($row->dayOfEntry)    
	                  ->setPictures($arraypict)                              
	                  ->setMapper($this);    
	                            
	                //  -
	            //add machine to array
	            $entries[] = $entry;	                    
	        }
	        
	        $mainResult[] = $entries;
    	}
        return $mainResult;        
    }

  /**
     * Delete a user entry by id
     * 
     * @param  int $id 
     * @return void
     */
    public function delete($idMachine)
    {
    	//get all pictures for machine    	
    	$pict = new Model_Picture();
        $pict->setMachineId($idMachine);
        $pictures = $pict->fetchAll();
        
        echo('deleting '. count($pictures) . 'photos');
                
        //deleteing all pictures
        foreach($pictures as $picture)
        {   
        	$urlSmallPic = $picture->getThumbUrl() . $picture->getThumbName();
        	$urlSmallPic = strchr($urlSmallPic, 'p'); //cuting first char - '/'
        	unlink($urlSmallPic);        	
  			$this->getDb()->Delete('Thumbs', 'id =' . (int)$picture->getThumbId());     
        	
        	$urlBigPic = $picture->getUrl() . $picture->getName();
        	$urlBigPic = strchr($urlBigPic, 'p');	//cuting first char - '/' 
        	unlink($urlBigPic);
        	$this->getDb()->Delete('Pictures', 'id =' . (int)$picture->getId());        	        	
        }
        
        $this->getDb()->Delete('Pictures', 'idMachine =' . (int)$idMachine);
        
        //deleting machine
        $this->getDb()->Delete('Machines', 'id =' . (int)$idMachine);
    }
    
    /**
     * Save a user entry
     * 
     * @param  ModelUser $user 
     * @return void
     */
    public function save(Model_Machine $machine)
    {
        $dataMachine = array(
        	'idUser' => (string)$machine->getIdUser(),
        	'idMainType' => (string)$machine->getIdMainType(),
        	'idSecondaryType' => (string)$machine->getSecondaryType(),
            'name'   => $machine->getName(),
        	'yearBuilt' => (string)$machine->getYearBuilt(),
        	'hours' =>(string)$machine->getHours(),
        	'price' =>(string)$machine->getPrice(),
        	'description' => $machine->getDescription(),
        	'condition' => $machine->getCondition(),           
        );
        
        //jesli w obiekcie user nie ma ustawionego id to oznacza to ze jest to
        //nowy obiekt i wkladamy go do bazy
        if ( null === ( $id = $machine->getId() ) ) 
        {
           unset($dataMachine['id']);
           $this->getDb()->insert('Machines',$dataMachine);
           $idMachine = $this->getDb()->lastInsertId();	//pobranie id uprzednio wstawionej maszyny
           $pict = $machine->getPictures();
           $test =0;
           foreach ($pict as $item)
           {	
           		$tmp = $item;
           		$dataPictures = array
	        	(
	        		'idMachine'	=> $idMachine,
	        		'name'		=> $tmp->getName(),
	        		'url'		=> $tmp->getUrl()        		
	        	);
			    
			    ++$test;
            	$this->getDb()->insert('Pictures',$dataPictures);
              	$idPicturetmp = $this->getDb()->lastInsertId();
            	$dataThumbs = array
            	(
            		'idPicture' => (string)$idPicturetmp,
            		'name' => $tmp->getThumbName(),
            		'url' => $tmp->getThumbUrl()
            	);
            	$this->getDb()->insert('Thumbs',$dataThumbs);
            	unset($dataPictures);
            	unset($dataThumbs);
            }
          
        }
        //jesli w obiekcie user mamy ustawiony atrybut id to oznacza to ze obiekt
        //ten juz istnieje w klasie i updatujemy baze
        else 
        {            
            $this->getDb()->update('Machines', $dataMachine, array('id = ?' => $machine->getId()));                      
        }
    }
    
    /**
     * Get all Main Types
     *
     * @return MainTypes[]
     */
    public static function getMainTypes()
    {
        $db =  Zend_Registry::get('db');    
        $sql = "SELECT * FROM MainTypes";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);    	
       	$resultSet = $db->fetchAll($sql);
        $MainTypes =array();
        foreach ($resultSet as $row)
        {
        	$MainTypes[] = $row;
        }
        return $MainTypes;
    }
 	

    /**
     * Get all Secondary Types 
     *
     * @param int $idMainType 
     * @return MainTypes[]
     */
	public static function getSecondaryTypes($idMainType)
    {
        $db =  Zend_Registry::get('db');    
        $sql = "SELECT * FROM SecondaryTypes
        		WHERE idMainType=".$idMainType.'
        		ORDER BY id ';
        $db->setFetchMode(Zend_Db::FETCH_OBJ);    	
       	$resultSet = $db->fetchAll($sql);
        $SecondaryTypes =array();
        foreach ($resultSet as $row)
        {
        	$SecondaryTypes[] = $row;
        }
        return $SecondaryTypes;
    }
      
    public function getSecondaryType($id)
    {
    	$sql = 'SELECT * FROM  SecondaryTypes WHERE id = '.$id;
    	$result = $this->getDb()->fetchRow($sql);
    	return $result;
    }
    
	public function getMainType($id)
    {
    	$sql = 'SELECT  m.id , m.name FROM MainTypes as m , SecondaryTypes as s
				WHERE (s.id='.$id. ')AND(m.id=s.idMainType)' ;
		$result = $this->getDb()->fetchRow($sql);
		return $result;
    }

    public function getMainTypeNameById($id)
    {
    	$sql = 'SELECT name FROM MainTypes
				WHERE id='.$id;
    	$result = $this->getDb()->fetchRow($sql);    	
    	
    	return $result->name;
    }
    
    public function getSecondaryTypeNamesByMainId($id)
    {
    	$sql = 'SELECT name FROM  SecondaryTypes
    			WHERE idMainType = '.$id.'
    			ORDER BY id';
    			
    	$sqlResult = $this->getDb()->fetchAll($sql);
    	
    	$result = array();
    	foreach($sqlResult as $row)
    	{
    		$result[] = $row->name;
    	}
    	
    	return $result;
    }
    
	public function getSecondaryTypeIdByMainId($id)
    {
    	$sql = 'SELECT id FROM  SecondaryTypes
    			WHERE idMainType = '.$id.'
    			ORDER BY id';
    	
    	$sqlResult = $this->getDb()->fetchAll($sql);
    	
    	$result = array();
    	foreach($sqlResult as $row)
    	{
    		
    		$result[] = $row->id;
    	}
    	
    	return $result;
    }
    
    public function GetLastMachines($number)
    {
    	$sql = 'SELECT * FROM Machines	    			
    			ORDER BY dayOfEntry DESC
    			LIMIT '.$number;    			
    	
        $resultSet = $this->getDb()->fetchAll($sql);
        
    	$entries = array();   
        foreach ($resultSet as $row)  
        {	        	
        	$pict = new Model_Picture();
        	$pict->setMachineId($row->id);
        	$arraypict = $pict->fetchAll();
            $entry = new Model_Machine();
            $entry->setId($row->id)  
            	  ->setIdUser($row->idUser)
            	  ->setMainType($row->idMainType)
            	  ->setSecondaryType($row->idSecondaryType)           	
                  ->setName($row->name)
                  ->setYearBuilt($row->yearBuilt)
                  ->setDescription($row->description)  
                  ->setPrice($row->price)
                  ->setHours($row->hours)
                  ->setCondition($row->condition)
                  ->setDayOfEntry($row->dayOfEntry)    
                  ->setPictures($arraypict)                              
                  ->setMapper($this);    
                            
            //add machine to array
            $entries[] = $entry;	                    
        }
  
        
        return $entries;
    }
}

?>