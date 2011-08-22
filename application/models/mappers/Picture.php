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
    
     /**
   	 *  Fetch all entries
     * 
     * @return array
     */
    public function fetchAll($id_Machine)
    {
    	$sql = 'SELECT p.id \'id\', p.idMachine \'idMachine\', p.name \'name\', p.url \'url\',
    	t.id \'thumbId\' ,t.name \'thumbName\', t.url \'thumbUrl\' 
    	FROM Pictures as p , Thumbs as t
    	WHERE (p.idMachine='.$id_Machine.')AND(p.id=t.idPicture)
    	ORDER BY p.name ASC';
        	
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
           		  ->setThumbid($row->thumbId) 
             	  ->setThumbName($row->thumbName) 	
            	  ->setThumbUrl($row->thumbUrl) 	
            	  ->setMapper($this);   
            //add machine to array
            $entries[] = $entry;            
        	}
        	return $entries;   
    }
  
}
?>
