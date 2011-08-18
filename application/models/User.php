<?php

class Model_User
{		
	/** 
	 * @var string
	 */
	protected $sName;
	
	/** 
	 * @var string
	 */
	protected $sSurname;
	
	/** 
	 * @var string
	 */
	protected $sSex;
	
	/** 
	 * @var string
	 */
	protected $sTelephone;
	
	/** 
	 * @var string
	 */		
	protected  $sRole;
	
	/** 
	 * @var string
	 */		
	protected  $sMail;
	
	/** 
	 * @var string
	 */		
	protected  $sNick;
	
	/** 
	 * @var string
	 */		
	protected  $sCreated;
	
	/** 
	 * @var string
	 */		
	protected  $sPassword;
	
	/** 
	 * @var int
	 */
	protected $iId;
	
	
	/** 
	 * @var Model_Mapper_User
	 */
	protected $_mapper;	
	
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
	 * Get surname
	 * 
	 * @return string|null
	 */
	public function getSurname()
	{
		return $this->sSurname;
	}	
	
	/**
	 * Set surname
	 * 
	 * @param string $surname
	 * @return Model_User
	 */
	public function setSurname($surname)
	{
		$this->sSurname = (string)$surname;
		return $this;
	}
	
	/**
	 * Get sex
	 * 
	 * @return string|null
	 */
	public function getSex()
	{
		return $this->sSex;
	}	
	
	/**
	 * Set sex
	 * 
	 * @param string $sex
	 * @return Model_User
	 */
	public function setSex($sex)
	{
		$this->sSex = (string)$sex;
		return $this;
	}
	
	/**
	 * Get telephone
	 *
	 * @return string|null
	 */
	public function getTelephone()
	{
		return $this->sTelephone;
	}	
	
	/**
	 * Set telephone
	 * 
	 * @param string $telephone
	 * @return Model_User
	 */
	public function setTelephone($telephone)
	{
		$this->sTelephone = (string)$telephone;
		return $this;
	}
	
	/**
	 * Get role
	 *
	 * @return array string|null
	 */
	public function getRole()
	{
		return $this->sRole;
	}	
	
	/**
	 * Set role
	 * 
	 * @param array string $roleName
	 * @return Model_User
	 */
	public function setRole($role)
	{
		$this->sRole = $role;
		return $this;
	}
	
	/**
	 * Get mail
	 *
	 * @return string|null
	 */
	public function getMail()
	{
		return $this->sMail;
	}	
	
	/**
	 * Set mail
	 * 
	 * @param string $mail
	 * @return Model_User
	 */
	public function setMail($mail)
	{
		$this->sMail = (string)$mail;
		return $this;
	}
	
	/**
	 * Get nick
	 *
	 * @return string|null
	 */
	public function getNick()
	{
		return $this->sNick;
	}	
	
	/**
	 * Set nick
	 * 
	 * @param string $nick
	 * @return Model_User
	 */
	public function setNick($nick)
	{
		$this->sNick = (string)$nick;
		return $this;
	}
	
	/**
	 * Get created date
	 *
	 * @return string|null
	 */
	public function getCreatedDate()
	{
		return $this->sCreated;
	}	
	
	/**
	 * Set created date
	 * 
	 * @param string $created
	 * @return Model_User
	 */
	public function setCreatedDate($createdDate)
	{
		$this->sCreated = (string)$createdDate;
		return $this;
	}
	
	/**
	 * Get password coded in MD5
	 *
	 * @return string|null
	 */
	public function getPassword()
	{
		return $this->sPassword;
	}	
	
	/**
	 * Set password (change on MD5 string)
	 * 
	 * @param string $password
	 * @return Model_User
	 */
	public function setPassword($password)
	{
		$this->sPassword = (string)$password;
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
	 * @return Model_User
	 */
	public function setId($id)
	{
		$this->iId = (int)$id;
		return $this;
	}
	
	/**
	 * Get data mapper
	 * 
	 * @return Model_Mapper_User
	 */
	public function getMapper()
	{
		if (null === $this->_mapper) 
		{
            $this->setMapper(new Model_Mapper_User());
        }
		return $this->mapper;
	}
	
	/**
	 * Set data mapper
	 * 
	 * @param $mapper
	 * @return ModelUser
	 */
	public function setMapper($mapper)
	{
		$this->mapper = $mapper;
		return $this;
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
     * Find an entry
     *
     * Resets entry state if matching id found.
     * 
     * @param  int $id 
     * @return Default_Model_Guestbook
     */
    public function find($id)
    {    	
    	$this->getMapper()->find($id, $this);
    	        
        return $this;
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
    
    /**
     * Delete entry 
     */
    public function delete($id)
    {
         $this->getMapper()->delete($id);
    }
    
    /**
     * Add user to role
     * 
     * @param (int) $idRole
     * @return Model_User
     */
    public function AddRole($idRole)
    {
    	$this->getMapper()->AddRoleToUser($idRole, $this);
    	return $this;
    }
    
    /**
     * remove user from role
     * 
     * @param (int) $idRole
     * @return Model_User
     */
    public function RemoveRole($idRole)
    {
    	$this->getMapper()->RomoveRoleFromUser($idRole, $this);
    	return $this;
    }    
}
