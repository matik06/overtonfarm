<?php
class Model_Mapper_Picture
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
           $this->getDb()->setFetchMode(Zend_Db::FETCH_OBJ);      
           //$this->db = Zend_Db::factory($asdf,$sadf);           
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
    
    public function getLastId()
    {
    	$db = Zend_Registry::get('db');
    	
    	$sql = 'SELECT MAX(id) FROM Pictures;';
    	$resultQ = $db->fetchRow($sql);
    	
    	$result = 1;
    	foreach($resultQ as $row)
    	{
    		$result += $row;
    	}
    	
    	return $result;
    }
    
    public function getCurrentMaxOrdr($machineId)
    {
    	$db = Zend_Registry::get('db');
    	
    	$sql = 'SELECT max(ordr) FROM Pictures
				WHERE idMachine = '.$machineId;
    	$sqlResult = $db->fetchRow($sql);
    	
    	$result = 0;
    	foreach($sqlResult as $row)
    	{
    		$result = $row;
    	}
    	
    	return $result;    	
    }
    
     /**
   	 *  Fetch all entries
     * 
     * @return array
     */
    public function fetchAll($id_Machine)
    {
    	$sql = 'SELECT p.id \'id\', p.idMachine \'idMachine\', p.name \'name\', p.url \'url\', p.ordr \'ordr\',
    	t.id \'thumbId\' ,t.name \'thumbName\', t.url \'thumbUrl\', t.idPicture \'thumbIdPicture\'  
    	FROM Pictures as p , Thumbs as t
    	WHERE (p.idMachine='.$id_Machine.')AND(p.id=t.idPicture)
    	ORDER BY p.ordr ASC';
        	
        $resultSet = $this->getDb()->fetchAll($sql);
       //array to store all machines
       $entries   = array();     
       $i=0;
     	foreach ($resultSet as $row) {
     		++$i;
            $entry = new Model_Picture() ;    
            $entry->setId($row->id)  
            	  ->setMachineId($row->idMachine)  	  
            	  ->setName($row->name) 
            	  ->setUrl($row->url) 
            	  ->setOrder($row->ordr)
           		  ->setThumbid($row->thumbId) 
             	  ->setThumbName($row->thumbName) 	
             	  ->setThumbPictureId($row->thumbIdPicture)
            	  ->setThumbUrl($row->thumbUrl) 	            	  
            	  ->setMapper($this);   
            //add machine to array
            $entries[] = $entry;            
        	}
        	
        	return $entries;   
    }
    
    public function getPictureByThumbId(Model_Picture $pic)
    {
    	$sql = 'SELECT p.id \'id\', p.idMachine \'idMachine\', p.name \'name\', p.url \'url\', p.ordr \'ordr\',
    	t.id \'thumbId\' ,t.name \'thumbName\', t.url \'thumbUrl\', t.idPicture \'thumbIdPicture\'  
    	FROM Pictures as p 
    	JOIN Thumbs as t ON p.id = t.idPicture 
    	WHERE t.id='.$pic->getThumbId();
        	
        $queryResult = $this->getDb()->fetchAll($sql);
        
       //array to store all machines
       $picture = new Model_Picture();     

     	foreach ($queryResult as $row) {    
            $picture->setId($row->id)  
            	  	->setMachineId($row->idMachine)  	  
            	  	->setName($row->name) 
            	  	->setUrl($row->url) 
            	  	->setOrder($row->ordr)
           		  	->setThumbid($row->thumbId) 
             	  	->setThumbName($row->thumbName) 	
             	  	->setThumbPictureId($row->thumbIdPicture)
            	  	->setThumbUrl($row->thumbUrl) 	            	  
            	  	->setMapper($this);               
        	}
        	
        	return $picture;      
    }
    
    public function save(Model_Picture $picture, $idMachine) 
    {
    	    	
		$dataPictures = array
       	(
	        'idMachine'	=> $idMachine,
	        'name'		=> $picture->getName(),
	        'url'		=> $picture->getUrl(),
       		'ordr'		=> $picture->getOrder()        			        
       	);
			    
        $this->getDb()->insert('Pictures',$dataPictures);
        $idPicturetmp = $this->getDb()->lastInsertId();
        
        $dataThumbs = array
        (
        	'idPicture' => (string)$idPicturetmp,
        	'name' => $picture->getThumbName(),
        	'url' => $picture->getThumbUrl()
        );
        
        $this->getDb()->insert('Thumbs',$dataThumbs);
            	
        unset($dataPictures);
        unset($dataThumbs);
    }
    


    public function update(Model_Picture $picture)
    {
    	$dataPictures = array
       	(
	        'idMachine'	=> $picture->getMachineId(),
	        'name'		=> $picture->getName(),
	        'url'		=> $picture->getUrl(),
       		'ordr'		=> $picture->getOrder()        			        
       	);
			    
        $this->getDb()->update('Pictures', $dataPictures, array('id = ?' => $picture->getId()));        
        
        $dataThumbs = array
        (
        	'idPicture' => $picture->getThumbPictureId(),
        	'name' => $picture->getThumbName(),
        	'url' => $picture->getThumbUrl()
        );
        
        $this->getDb()->update('Thumbs', $dataThumbs, array('id = ?' => $picture->getThumbId()));
            	
        unset($dataPictures);
        unset($dataThumbs);
    }      
}
?>
