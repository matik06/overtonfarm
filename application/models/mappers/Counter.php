<?php

class Model_Mapper_Counter
{
	private $db;
	
	
	public function setDb()
    {
        if (null === $this->db)
        {
           $this->db = Zend_Registry::get('db');     
           $this->getDb()->setFetchMode(Zend_Db::FETCH_OBJ);      
        }       
        
        return $this;
    }
    
    
	public function getDb()
    {
        if (null === $this->db) 
        {
            $this->setDb();
        }
        return $this->db;
    }
    
    public function getHits(Model_Counter $counter)
    {
    	$sql = 'SELECT hits FROM Counter WHERE id = 1';
    	$result = $this->getDb()->fetchRow($sql);
    	
    	
    	$counter->setHits($result->hits);    	
    }
    
    public function save(Model_Counter $counter)
    {
    	$hitsData = array(
        	'hits' => $counter->getHits(),
    	);
    	$this->getDb()->update('Counter', $hitsData, array('id = ?' => 1));  
    }
}
