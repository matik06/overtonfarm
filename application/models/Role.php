<?php

class Model_Role
{
	/** 
	 * @var string
	 */
	protected $sName;
	
	/** 
	 * @var string
	 */
	protected $sDescription;
	
	/** 
	 * @var int
	 */
	protected $iId;
	
	/** 
	 * @var Model_Mapper_Role
	 */
	protected $mapper;
	
	/**
	 * Get name
	 * 
	 * @return null|string
	 */
	public function getName()
	{
		return $this->sName;
	}

	/**
	 * Set name
	 * 
	 * @param string $name
	 * @return Model_User
	 */
	public function setName($name)
	{
		$this->sName = (string)$name;
		return $this;
	}
	
	/**
	 * Get description
	 * 
	 * @return string|null
	 */
	public function getDescription()
	{
		return $this->sDescription;
	}

	/**
	 * Set description
	 * 
	 * @param string $description
	 * @return Model_Role
	 */
	public function setDescription($description)
	{
		$this->sDescription = (string)$description;
		return $this;
	}
	
	/**
	 * Get id
	 *
	 * @return int|null
	 */
	public function getId()
	{
		return $this->iId;
	}	
	
	/**
	 * Set id
	 * 
	 * @param int $id
	 * @return Model_Role
	 */
	public function setId($id)
	{
		$this->iId = (int)$id;
		return $this;
	}	
		
	/**
	 * Get data mapper
	 * 
	 * @return Model_Mapper_Role
	 */
	public function getMapper()
	{
		if (null === $this->mapper) 
		{
            $this->setMapper(new Model_Mapper_Role());
        }
		return $this->mapper;
	}
	
	/**
	 * Set data mapper
	 * 
	 * @param $mapper
	 * @return ModelRole
	 */
	public function setMapper($mapper)
	{
		$this->mapper = $mapper;
		return $this;
	}
	
   /**
     * Find an entry by name
     *
     * Resets entry state if matching id found.
     * 
     * @param  string $roleName 
     * @return Model_Role
     */
	public function findId($roleName)
	{
		return $this->getMapper()->getId($roleName, $this);
	}
	
   /**
     * Find an entry
     *
     * Resets entry state if matching id found.
     * 
     * @param  int $id 
     * @return Model_Role
     */
    public function find($id)
    {    	
    	$this->getMapper()->find($id, $this);
    	        
        return $this;
    }
    
    public function getIdByName($rolename)
    {
    	return $this->getMapper()->getId($rolename, $this);
    }
    
    /**
     * Fetch all entries
     * 
     * @return array
     */
    public function fetchAll()
    {
        return $this->getMapper()->fetchAll();
    }
}