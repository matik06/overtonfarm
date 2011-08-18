<?php

// Set the initial include_path. You may need to change this to ensure that 
// Zend Framework is in the include_path; additionally, for performance 
// reasons, it's best to move this to your web server configuration or php.ini 
// for production.
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__) . '/../library'),
    get_include_path(),
)));

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

/** Zend_Application */
require_once 'Zend/Application.php';  

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini'
);

//polaczenie z baza danych
$config = new Zend_Config_Ini('../application/configs/application.ini', 'production');
Zend_Registry::set('config', $config);
$db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params->toArray());
$db->query( 'SET NAMES "utf8"' );
Zend_Db_Table::setDefaultAdapter($db);
Zend_Registry::set('db', $db);

$application->bootstrap();
$application->run();
