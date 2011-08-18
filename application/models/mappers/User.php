<?php

class Model_Mapper_User
{
	protected $db;
	
	/**
	 * Set Connection to database
	 * 
	 * @return Model_Mapper_UserInRole
	 */
    public function setDb()
    {
        if (null === $this->db)
        {
        	$this->db = Zend_Registry::get('db');
        	$this->db->setFetchMode(Zend_Db::FETCH_OBJ);    
        	         
            //zmienna pomocnicza sluzaca do generowanie podpowiedzi
            //$this->db = Zend_Db::factory($asdf,$sadf);
        }       
        
        return $this;
    }
	
     /**
     *Get connection to database
     * 
     * @return db
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
     * Delete a user entry by id
     * 
     * @param  int $id 
     * @return void
     */
    public function delete($id)
    {
    	$this->getDb()->Delete('Memberships', 'idUser =' . (int)$id);
    	$this->getDb()->Delete('UserInRole', 'idUser =' . (int)$id);	
    	$this->getDb()->Delete('Users', 'id =' . (int)$id);    	
    }
    
	/**
     * Save a user entry
     * 
     * @param  ModelUser $user 
     * @return void
     */
    public function save(Model_User  $user)
    {
        $dataUser = array(
            'name'   => $user->getName(),
        	'surname' => $user->getSurname(),
        	'sex'   => $user->getSex(),
            'telephone' => $user->getTelephone(),            
        );
        
        $dataMembership = array
        (
        	'nick'		 => $user->getNick(),
        	'mail'		 => $user->getMail(),        	
        	'password'	 => md5($user->getPassword()),
        	'createDate' => $user->getCreatedDate(), 
        );      

        //jesli w obiekcie user nie ma ustawionego id to oznacza to ze jest to
        //nowy obiekt i wkladamy go do bazy
        if ( null === ( $id = $user->getId() ) ) 
        {
            unset($dataUser['id']);

            $this->getDb()->insert('Users',$dataUser);
            $idUser = $this->getDb()->lastInsertId();	//pobranie id wyzej wstawionego usera
            
            //nie wiem jak do tablicy array dodac nowy element('idUser'=>$idUser) wiec stworzylem nowa tabele
            $dataMembership2 = array
	        (
	        	'idUser'	=> $idUser,
	        	'nick'		=> $user->getNick(),
	        	'mail'		=> $user->getMail(),        	
	        	'password'	=> md5($user->getPassword()),
	        	'createDate'=> $user->getCreatedDate(), 
	        );
			            
            $this->getDb()->insert('Memberships',$dataMembership2);
            
            //dodanie domyslnego uprawnienia - guest
            $dataUserInRole = array
            (
            	'idUser' => $idUser,
            	'idRole' => 3,
            );
            $this->getDb()->insert('UserInRole', $dataUserInRole);
        }
        //jesli w obiekcie user mamy ustawiony atrybut id to oznacza to ze obiekt
        //ten juz istnieje w klasie i updatujemy baze
        else 
        {            
            $this->getDb()->update('Users', $dataUser, array('id = ?' => $user->getId()));           
            $this->getDb()->update('Memberships', $dataMembership, array('idUser = ?' => $user->getId()));
        }

    }

    protected function getRoles($id)
    {    	     
    	$sqlUserInRole = 'SELECT * FROM UserInRole WHERE idUser = ?';
    	$resultUserInRole = $this->getDb()->fetchAll($sqlUserInRole, $id);        
    	
        $sqlRoleName = 'SELECT * FROM Roles WHERE id = ?';
        $roleNames = array();
        
        foreach ($resultUserInRole as $row) 
        {        	
        	$singleRole =  $this->getDb()->fetchRow($sqlRoleName, $row->idRole);        	        	    	  
        	$roleNames[] = $singleRole->name;        		
        }        
        
        return $roleNames;
    }
    
    /**
     * Find a user entry by id
     * 
     * @param  int $id 
     * @param  Model_User $user 
     * @return void
     */
    public function find($id, Model_User  $user)
    {    	     
    	//get data from Users Table
    	$sql = 'SELECT * FROM Users WHERE id = ?';
    	$result = $this->getDb()->fetchRow($sql, $id);
    	
    	//if user not exist then exit
    	if (null == $result) 
        {        	
            return;
        }        
        
    	//get data from Membership Table
    	$sqlMembership = 'SELECT * FROM Memberships WHERE idUser = ?';
    	$resultMembership = $this->getDb()->fetchRow($sqlMembership, $id);
    	
    	$roles = $this->GetRoles($id);    	
        
        $user->setId($result->id)
                  ->setName($result->name)
                  ->setSurname($result->surname)
                  ->setSex($result->sex)
                  ->setTelephone($result->telephone)
                  ->setMail($resultMembership->mail)
                  ->setNick($resultMembership->nick)
                  ->setCreatedDate($resultMembership->createDate)
                  ->setPassword($resultMembership->password)
                  ->setRole($roles);
    }

    /**
     * Fetch all users(id, name, surname, nick)
     * 
     * @return array
     */
    public function fetchAll()
    {
    	$sql = 'SELECT * FROM Users';
    	$sqlMembership = 'SELECT * FROM Memberships WHERE idUser = ?';
    	
    	$result = array();
        $resultSet = $this->getDb()->fetchAll($sql);                         
        $entries   = array();        
        
        foreach ($resultSet as $row) 
        {
            $entry = new Model_User();
            $nick = $this->getDb()->fetchRow($sqlMembership, $row->id)->nick; 
            
            $entry->setId($row->id)
                  ->setName($row->name)
                  ->setSurname($row->surname)
                  ->setNick($nick)
                  ->setMapper($this);
            $entries[] = $entry;
            
            $result[$row->id] = $nick;            
        }
        //return $entries;
    	return $result;
    }
    
    /**
     * set role for user
     * 
     * @param int $roleId
     * @param Model_User $user
     * @return void
     */
    public function AddRoleToUser($roleId, Model_User $user)
    {    	
    	$userInRole = array(
    		'idUser' 	=> $user->getId(),//
    		'idRole'	=> $roleId,
    	);
    	
    	$this->getDb()->insert('UserInRole', $userInRole);
    }
    
    /**
     * Remove role from user
     * 
     * @param int $roleId
     * @param Model_User $user
     * @return void
     */
    public function RomoveRoleFromUser($roleId, Model_User $user)
    {
    	
    	$this->getDb()->Delete('UserInRole', 'idUser =' . (int)$user->getId() . ' AND ' . 'idRole =' . (int)$roleId);
    }
}