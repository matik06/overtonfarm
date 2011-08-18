<?php

class Model_AuthAdapter implements Zend_Auth_Adapter_Interface
{
	private $_nick;
	private $_password;
	
	
	public function __construct($nick, $password)
	{
		$this->_nick = $nick;
		$this->_password = $password;
	}
	
	
	
	public function authenticate()
	{
		$db = Zend_Registry::get('db');
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$user = new Model_User();
		
		$sql = 'SELECT * FROM Memberships WHERE nick = ?';		
		$identity = $db->fetchRow($sql, $this->_nick);
		
		$messages = array();
		$authenticated = false;		
		
		
		
		if(!$identity->nick)
		{
			$messages[] = 'Your account nick is incorect';
		}
		else if($identity->password != md5($this->_password))
		{
			$messages[] = 'Password is incorect';
		}
		else
		{
			$authenticated = true;
			$identity = $user->find($identity->idUser);
		}
		
		return new Zend_Auth_Result($authenticated, $identity, $messages);		
	}
	
}