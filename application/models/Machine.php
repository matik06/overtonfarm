<?php
class Model_Machine
{
	/**
	 * @var int
	 */
	protected $iId;
	
	/**
	 * @var int
	 */
	protected $iIdUser;
	
	/**
	 * @var int
	 */
	protected $iIdMainType;
	
	 /**
	 * @var int
	 */
	protected $iIdSecondaryType;
	
	/**
	 * @var string
	 */
	protected $sName;
	
	/**
	 * @var string
	 */
	protected $sYearBuilt;
	
	/**
	 * @var int
	 */
	protected $iHours;
	
	/**
	 * @var double
	 */
	protected $dPrice;
	
	/**
	 * @var string
	 */
	protected $sDescription;
	
	/**
	 * @var string
	 */
	protected $sCondition;
	
	/**
	 * @var string
	 */
	protected $sDayOfEntry;
	
	/**
	 * @var string[]
	 */	 
	protected $pPictures= Array(); 	
	
	/** 
	 * @var Model_Mapper_Role
	 */
	protected $mapper;
	
	
	/**
	 * Get machine id
	 *
	 * @return int|null
	 */
	public function getId()
	{
		return $this->iId;
	}	
	
	/**
	 * Set machine id
	 * 
	 * @param int $id
	 * @return Model_Machine
	 */
	public function setId($id)
	{
		$this->iId = (int)$id;	
		return $this;
	}
	
	
	/**
	 *Get user id
	 *
	 * @return int|null
	 */
	public function getIdUser()
	{
		return $this->iIdUser;
	}
	
	/**
	 * Set user id
	 *
	 * @param int $idUser
	 * @return Model_Machine
	 */
	public function setIdUser($idUser)
	{	
		$this->iIdUser = (int)$idUser;
		return $this;
	}
	
	
	/**
	 *Get machine main type
	 *
	 * @return int|null
	 */
	public function getIdMainType()
	{
		return $this->iIdMainType;
	}
	
	/**
	 * Set machine main type
	 *
	 * @param int $idMainType
	 * @return Model_Machine
	 */
	public function setMainType($idMainType)
	{	
		$this->iIdMainType = (int)$idMainType;
		return $this;
	}
	
	
	/**
	 *Get machine secondary type
	 *
	 * @return int|null
	 */
	public function getSecondaryType()
	{
		return $this->iIdSecondaryType;
	}
	
	/**
	 * Set machine secondary type
	 *
	 * @param int $idSecondaryType
	 * @return Model_Machine
	 */
	public function setSecondaryType($idSecondaryType)
	{	
		$this->iIdSecondaryType = (int)$idSecondaryType;
		return $this;
	}
	
	
	/**
	 *Get machine name
	 *
	 * @return string|null
	 */
	public function getName()
	{
		return $this->sName;
	}
	
	/**
	 * Set machine name
	 *
	 * @param string $name
	 * @return Model_Machine
	 */
	public function setName($name)
	{	
		$this->sName =(string)$name;
		return $this;
	}
	
	
	/**
	 *Get machine year of built
	 *
	 * @return int|null
	 */
	public function getYearBuilt()
	{
		return $this->sYearBuilt;
	}
	
	/**
	 * Set machine year of built
	 *
	 * @param int $yearBuilt
	 * @return Model_Machine
	 */
	public function setYearBuilt($yearBuilt)
	{	
		$this->sYearBuilt =(string)$yearBuilt;
		return $this;
	}

	
	/**
	 *Get machine hours
	 *
	 * @return int|null
	 */
	public function getHours()
	{
		return $this->iHours;
	}
	
	/**
	 * Set machine hours
	 *
	 * @param int $hours
	 * @return Model_Machine
	 */
	public function setHours($hours)
	{	
		$this->iHours =(string)$hours;
		return $this;
	}
	
	
	/**
	 *Get machine Price
	 *
	 * @return double|null
	 */
	public function getPrice()
	{
		return $this->dPrice;
	}
	
	/**
	 * Set machine Price
	 *
	 * @param double $price
	 * @return Model_Machine
	 */
	public function setPrice($price)
	{	
		$this->dPrice =(string)$price;
		return $this;
	}
	
	
	 /**
	 * Get machine Description
	 *
	 * @return string|null
	 */
	public function getDescription()
	{
		return $this->sDescription;
	}
	
	/**
	 * Set machine Description
	 *
	 * @param string $description
	 * @return Model_Machine
	 */
	public function setDescription($description)
	{	
		$this->sDescription =(string)$description;
		return $this;
	}
	
	
	/**
	 * Get machine Condition
	 *
	 * @return string|null
	 */
	public function getCondition()
	{
		return $this->sCondition;
	}
	
	/**
	 * Set machine Condition
	 *
	 * @param string $condition
	 * @return Model_Machine
	 */
	public function setCondition($condition)
	{	
		$this->sCondition =(string)$condition;
		return $this;
	}
	
	
	/**
	 * Get machine DayOfEntry
	 *
	 * @return string|null
	 */
	public function getDayOfEntry()
	{
		return $this->sDayOfEntry;
	}
	
	/**
	 * Set machine DayOfEntry
	 *
	 * @param string $dayOfEntry
	 * @return Model_Machine
	 */
	public function setDayOfEntry($dayOfEntry)
	{
		$this->sDayOfEntry =(string)$dayOfEntry;
		return $this;
	}

	
	/**
	 * Get machine pictures
	 * 
	 * @return Picture[]
	 */
	public function getPictures()
	{
		return $this->pPictures;
	}
	
	/**
	 * Set machine pictures
	 * 
	 * @param $pictures
	 * @return Model_Machine
	 */
	public function setPictures($pictures)
	{
		$this->pPictures = $pictures;
		return $this;
	}
	
	
	/**
	 * Get data mapper
	 * 
	 * @return Model_Mapper_Machine
	 */
	public function getMapper()
	{
		if (null === $this->mapper) 
		{
            $this->setMapper(new Model_Mapper_Machine());
        }
		return $this->mapper;
	}
	
	/**
	 * Set data mapper
	 * 
	 * @param $mapper
	 * @return Model_Machine
	 */
	public function setMapper($mapper)
	{
		$this->mapper = $mapper;
		return $this;
	}
	
	
 	 /**
   	 *  Fetch all entries by main id and secondary id
     * 
     * @return array
     */
    public function fetchAll()
    {
        return $this->getMapper()->fetchAll($this->iIdMainType,$this->iIdSecondaryType);
    }
    
	/**
   	 *  Fetch all entries by main id
     * 
     * @return array
     */
    public function fetchAllByMainType()
    {
        return $this->getMapper()->fetchAllByMainType($this->iIdMainType);
    }
    
     /**
     * Save the current entry
     * 
     * @return void
     */
    public function save()
    {
        $this->getMapper()->save($this);
    }
    
    /**
     * Delete entry 
     */
    public function delete($id)
    {
         $this->getMapper()->delete($id);
    }
    
    public function getSecondaryTypeName($id)
    {
    	return $this->getMapper()->getSecondaryTpeName($id);	
    }
    
    public function getSecondaryTypeAll($id)
    {
    	return $this->getMapper()->getSecondaryType($id);
    }
    
    public function getMainTypeAll($id)
    {
    	return $this->getMapper()->getMainType($id);
    }
    
    /**
     * Return name MainType machine from id
     * 
     * @param $id
     * @return name of MainType machine by id
     */
    public function getMainTypeNameById($id)
    {
    	return $this->getMapper()->getMainTypeNameById($id);
    }
    
    /**
     * Return all of secondary type names belongs to main type(id)
     * @param $id main type
     * @return array names
     */
    public function getSecondaryTypeNamesByMainId($id)
    {
    	return $this->getMapper()->getSecondaryTypeNamesByMainId($id);
    }
    
    public function GetLastMachines($number)
    {    	    	    	
    	return $this->getMapper()->GetLastMachines($number);   		
    }
}

?>
