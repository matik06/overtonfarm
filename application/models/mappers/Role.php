<?php
class Model_Mapper_Role
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
           //$this->db = Zend_Db::factory($asdf,$sadf);           
        }       
        
        return $this;
    }
	
    /**
     *get instance connection to database
     * 
     * @return Model_Mapper_Role
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
     * Find a role entry by id
     * 
     * @param  int $id 
     * @param  Model_Role $role 
     * @return void
     */
    public function find($id, Model_Role $role)
    {
    	$sql = 'SELECT * FROM Roles WHERE id = ?';
    	$result = $this->getDb()->fetchRow($sql, $id, zend_db::FETCH_OBJ);
    	
    	
        if (null == $result) 
        {        	
            return;
        }        
        
        $role->setId($result->id)
        		->setName($result->name)        		
        		->setDescription($result->description)        		
        		->setMapper($this);                 
    }
    
    /**
     * Find a role entry by name
     * 
     * @param  string $roleName 
     * @param  Model_Role $role 
     * @return void
     */
    public function getId($roleName, Model_Role $role)
    {
    	$sql = 'SELECT id FROM Roles WHERE name = ?';
    	$result =  $this->getDb()->fetchRow($sql, $roleName, zend_db::FETCH_OBJ);
    	
    	if (null == $result) 
        {        	
            return;
        }   
        
        $role->setId($result->id)
        		->setName($result->name)        		
        		->setDescription($result->description)        		
        		->setMapper($this);
        		
        return $result->id;
    }

    /**
     * Fetch all role entries
     * 
     * @return array
     */
    public function fetchAll()
    {    	
    	$sql = 'SELECT * FROM Roles';
    	$this->getDb()->setFetchMode(Zend_Db::FETCH_OBJ);    	
        $resultSet = $this->getDb()->fetchAll($sql);
        
        //array to store all roles
        $entries   = array();     
		$result = array();
        
        foreach ($resultSet as $row) {
            $entry = new Model_Role();
            
            $entry->setId($row->id)            	
                  ->setName($row->name)
                  ->setDescription($row->description)                                    
                  ->setMapper($this);                  
                  
            //add role to array
            $entries[] = $entry;
            $result[$row->name] = $row->name;            
        }
        //return $entries;
        return $result;        
    }
    
}
