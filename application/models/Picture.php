<?php
class Model_Picture
{
	/**
	 * @var int
	 */
	protected $iId;
	
	/**
	 * @var int
	 */
	protected $iIdMachine;
	
	/**
	 * @var string
	 */
	protected $sName;
	
	 /**
	 * @var string
	 */
	protected $sUrl;
	
	/**
	 * @var int
	 */
	protected $iThumbId;
	
	/**
	 * @var string
	 */
	protected $sThumbName;
	
	/**
	 * @var int
	 */
	protected $sThumbUrl;
	
	protected $iOrdr;
	
	protected $iThumbIdPicture;
	 
	 protected $_mapper;
	
/*	public function _construct()
	{}
	public function _construct($id, $idMachine,$name,$url,$thId,$thName,$thUrl)
	{ 
		$this->iId = $id;
		$this->iIdMachine = $idMachine;
		$this->iThumbId = $thId;
		$this->sName = $name;
		$this->sUrl = $url;
		$this->sThumbName = $thName;
		$this->sThumbUrl = $thUrl;
	}
	
	*/
	public function getId()
	{
		return $this->iId;
	}	
	
	/**
	 * Set picture id
	 * 
	 * @param int $id
	 * @return Model_Picture
	 */
	public function setId($id)
	{
		$this->iId = (int)$id;	
		return $this;
	}
	
	/**
	 * Get machine id
	 *
	 * @return int|null
	 */
	public function getMachineId()
	{
		return $this->iIdMachine;
	}	
	
	/**
	 * Set machine id
	 * 
	 * @param int $id
	 * @return Model_Picture
	 */
	public function setMachineId($id)
	{
		$this->iIdMachine = (int)$id;	
		return $this;
	}
	
	/**
	 * Get thumb id
	 *
	 * @return int|null
	 */
	public function getThumbId()
	{
		return $this->iThumbId;
	}	
	
	/**
	 * Set thumb id
	 * 
	 * @param int $id
	 * @return Model_Picture
	 */
	public function setThumbId($id)
	{
		$this->iThumbId = (int)$id;	
		return $this;
	}
	
	/**
	 * Get picture name
	 *
	 * @return string|null
	 */
	public function getName()
	{
		return $this->sName;
	}	
	
	/**
	 * Set picture name
	 * 
	 * @param string $name
	 * @return Model_Picture
	 */
	public function setName($name)
	{
		$this->sName = (string)$name;	
		return $this;
	}
	
		/**
	 * Get picture url
	 *
	 * @return string|null
	 */
	public function getUrl()
	{
		return $this->sUrl;
	}	
	
	/**
	 * Set picture url
	 * 
	 * @param string $ulr
	 * @return Model_Picture
	 */
	public function setUrl($url)
	{
		$this->sUrl = (string)$url;	
		return $this;
	}	
	
	/**
	 * Get thumb name
	 *
	 * @return string|null
	 */
	public function getThumbName()
	{
		return $this->sThumbName;
	}	
	
	/**
	 * Set thumb name
	 * 
	 * @param string $name
	 * @return Model_Picture
	 */
	public function setThumbName($name)
	{
		$this->sThumbName = (string)$name;	
		return $this;
	}
	
		/**
	 * Get thumb url
	 *
	 * @return string|null
	 */
	public function getThumbUrl()
	{
		return $this->sThumbUrl;
	}	
	
	/**
	 * Set thumb url
	 * 
	 * @param string $ulr
	 * @return Model_Picture
	 */
	public function setThumbUrl($url)
	{
		$this->sThumbUrl = (string)$url;	
		return $this;
	}
	
	public function getThumbPictureId()
	{
		return $this->iThumbIdPicture;
	}
	
	public function setThumbPictureId($id)
	{
		$this->iThumbIdPicture = $id;
		return $this;
	}
	
	public function getOrder()
	{
		return $this->iOrdr;
	}
	
	public function setOrder($order)
	{
		$this->iOrdr = $order;
		return $this;
	}
	
	/**
	 * Get data mapper
	 * 
	 * @return Model_Mapper_Machine
	 */
	public function getMapper()
	{
		if (null === $this->_mapper) 
		{
            $this->setMapper(new Model_Mapper_Picture());
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
   	 *  Fetch all entries
     * 
     * @return array
     */
    public function fetchAll()
    {
        return $this->getMapper()->fetchAll($this->getMachineId());
    }
    
    /**
     * delete all pictures from harddrive and database
     * 
     * @param $idMachnine
     * @return nothing
     */
    public function delete($idMachnine)
    {
    	$this->getMapper()->delete($idMachnine);
    }
    
    public function save($idMachine)
    {
    	$this->getMapper()->save($this, $idMachine);
    }
    
    public function update()
    {
    	$this->getMapper()->update($this);
    }
}
?>
