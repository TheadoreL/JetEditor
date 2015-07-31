<?php
/*
	Module:	General Settings;
	Author: Mean Machine;
	Create @ 2014-09-07;
*/
//General Settings
defined('CHAR_SET')				||	define('CHAR_SET', 'utf-8');						//Page Charset
defined('ROOT_PATH')			||	define('ROOT_PATH', dirname(__FILE__));				//Root directory
defined('APP_PATH')				||	define('APP_PATH', 'Modules/');						//Application PATH, modified by dr.white
// defined('HOME_PATH')			||	define('HOME_PATH', APP_PATH.'Home/');				//Home Script PATH, added by dr.white
// defined('ADMIN_PATH')		||	define('ADMIN_PATH', APP_PATH.'Admin/');			//Admin Script PATH, added by meanevo
defined('MODULE_PATH')			||	define('MODULE_PATH', APP_PATH.'Home/');			//Default Module PATH, added by meanevo
defined('COMMON_PATH')			||	define('COMMON_PATH', MODULE_PATH.'/Common/');
defined('COMMON_VIEW_PATH')		||	define('COMMON_VIEW_PATH', COMMON_PATH.'View/');
defined('PLUGINS_PATH')			||	define('PLUGINS_PATH', 'Libraries/Scripts/Plugins/');
defined('COMMONJS_PATH')		||	define('COMMONJS_PATH', 'Libraries/Scripts/Common/');
defined('PHP_FILE')				||  define('PHP_FILE', 'index.php');					//Default Entrance, modified by meanevo
defined('CONTEXT_PATH')			||  define("CONTEXT_PATH", str_replace(PHP_FILE, '', $_SERVER['SCRIPT_NAME']));		//Document PATH (http://localhost/xxxxxx/)
defined('RES_PATH')				||	define('RES_PATH', CONTEXT_PATH.APP_PATH);										//Resource PATH (http://localhost/xxxxxx/APP_PATH/)
defined('SCR_PATH')				||	define('SCR_PATH', $_SERVER['SCRIPT_NAME'].'/');								//Script PATH (http://localhost/xxxxxx/index.php)
defined('LIB_PATH')				||	define('LIB_PATH', CONTEXT_PATH.'Libraries/');									//Library PATH (http://localhost/xxxxxx/Libraries/)
defined('APP_TITLE')			||	define('APP_TITLE', '');								//Application Title
defined('LOGIN_CAPTCHA')		||	define('LOGIN_CAPTCHA', 0);														//Login Captcha Switch: 0 => Disable; 1 => Enable
defined('LOGIN_TIMEOUT')		||	define('LOGIN_TIMEOUT', 3600);													//Login Timeout (Second): 0 => Disable
//Framework Settings
defined('DOCUMENT_ROOT')		||	define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);	//Document Root Directory
defined('SMARTY_ENABLED')		||	define('SMARTY_ENABLED', 1);						//SMARTY Switch:  0 => Disable; 1 => Enable
defined('SMARTY_PATH')			||	define('SMARTY_PATH', rtrim($_SERVER['SCRIPT_FILENAME'], PHP_FILE).'Libraries/Smarty/libs/Smarty.class.php');	//SMARTY PATH
defined('RUNTIME_PATH')			||	define('RUNTIME_PATH', APP_PATH.'Runtime/');		//Runtime Directory
defined('TEMP_PATH')			||	define('TEMP_PATH', RUNTIME_PATH.'Temp/');			//Temporary Cache Directory
defined('CACHE_PATH')			||	define('CACHE_PATH', RUNTIME_PATH.'Cache/');		//Templates Cache Directory
defined('DEFAULT_GROUP')		||	define('DEFAULT_GROUP', 'Home');					//Default Group, added by Dr.White
defined('DEFAULT_CONTROLLER')	||	define('DEFAULT_CONTROLLER', 'home');				//Default Controller
defined('DEFAULT_ACTION')		||	define('DEFAULT_ACTION', 'index');					//Default Action
defined('MULTIPAGE_DEBUG')		||	define('MULTIPAGE_DEBUG', 1);						//Multipage Debug Mode -> Clear Multipage SESSION
//Database Settings
defined('DB_DEBUG_MODE')		||	define('DB_DEBUG_MODE', 0);							//Database Debug Mode -> Print Data, Query on Page
defined('DB_LOG_DSN')			||	define('DB_LOG_DSN', './log/database/');			//Database Log Location
defined('AUTH_TABLE')			||	define('AUTH_TABLE', 'user_data');					//Authentication Database Table Name
defined('GROUP_TABLE')			||	define('GROUP_TABLE', 'auth_group');				//User->Group Database Table Name
defined('RULE_TABLE')			||	define('RULE_TABLE', 'auth_rule');					//Group->Rule Database Table Name
defined('DB_BAK_DSN')			||	define('DB_BAK_DSN', './DB_Backup/');				//Database Backup Destination Directory
defined('DB_BAK_SIZE')			||	define('DB_BAK_SIZE', '20480');						//Database Backup Destination File Volume Size (KB)
//Log Settings
defined('LOG_ENABLED')			||	define('LOG_ENABLED', 1);							//Log Switch: 0 => Disable; 1 => Enable
defined('LOG_DEBUG_MODE')		||	define('LOG_DEBUG_MODE', 0);						//Log Debug Mode -> Print Logs on Page
defined('LOG_LEVEL')			||	define('LOG_LEVEL', 3);								//Log Level: 0 => LogIP 1 => +LogURI; 2 => +LogTime; 3 => +LogSESS
defined('LOG_DATE_FORMAT')		||	define('LOG_DATE_FORMAT', 1); 						//Date Format: 0 => RFC1123; 1 => ATOM; 2 => TIMESTAMP;
defined('LOG_SAVE_METHOD')		||	define('LOG_SAVE_METHOD', 1);						//Switch: 0 => File; 1 => Database
defined('ACCESS_LOG_DSN')		||	define('ACCESS_LOG_DSN', './log/web/');				//Save to File: Access Log Location
defined('EXCEL_EXT')			||	define('EXCEL_EXT', 0);								//Save Using Excel Version: 0 => Excel5; 1 => Excel2007
defined('LOG_EXPORT_DSN')		||	define('LOG_EXPORT_DSN', './log/');					//Log Export -> Excel Destination
defined('LOG_FILE_NAME')		||	define('LOG_FILE_NAME', '');						//Save to File: File Name
defined('LOG_TABLE')			||	define('LOG_TABLE', 'access_log');					//Save to DB: Table Name
//Upload Settings
defined('UPLOAD_DEBUG')			||	define('UPLOAD_DEBUG', 0);							//Upload Module Debug Mode Switch: 0 => Disable; 1 => Enable
defined('UPLOAD_PATH')			||	define('UPLOAD_PATH', 'Upload/');					//Save to Local: Directory Name
defined('UPLOAD_EXT')			||	define('UPLOAD_EXT', 'jpg|bmp|png|gif|jpeg');		//Allowed Upload File Extensions
defined('IMAGES_ONLY')			||	define('IMAGES_ONLY', 1);							//Only Allow Upload Image Files
defined('OVERWRITE_MODE')		||	define('OVERWRITE_MODE', 0);						//Overwrite File if Exists: 0 => Disable (Save as); 1 => Enable
defined('RENAME_MODE')			||	define('RENAME_MODE', 0);							//Use Auto Generate Filename: 0 => Use Origin Filename; 1 => Enable
defined('MAX_FILE_SIZE')		||	define('MAX_FILE_SIZE', 5*1024);					//Max Upload Size
//General Execution
ini_set('display_errors', 'Off');						//Debug
ini_set('max_execution_time', -1);						//Cancel timeout_limit
ini_set('memory_limit', -1);							//Cancel menory_limit
header('Content-Type: text/html; Charset='.CHAR_SET);	//Default Encoding
date_default_timezone_set('Asia/Shanghai');				//Default Timezone
//Autoload PHP Classes
function __autoload($className) {
	$include_path = '' //get_include_path()
					. ROOT_PATH . DIRECTORY_SEPARATOR . 'Includes' . PATH_SEPARATOR
					. ROOT_PATH . DIRECTORY_SEPARATOR . 'Includes' . DIRECTORY_SEPARATOR . 'MVCbaseClasses' . DIRECTORY_SEPARATOR . 'Controller' . PATH_SEPARATOR
					. ROOT_PATH . DIRECTORY_SEPARATOR . 'Includes' . DIRECTORY_SEPARATOR . 'MVCbaseClasses' . DIRECTORY_SEPARATOR . 'Model' . PATH_SEPARATOR
					. ROOT_PATH . DIRECTORY_SEPARATOR . 'Includes' . DIRECTORY_SEPARATOR . 'MVCbaseClasses' . DIRECTORY_SEPARATOR . 'View' . PATH_SEPARATOR
					. ROOT_PATH . DIRECTORY_SEPARATOR . 'Includes' . DIRECTORY_SEPARATOR . 'MVCbaseClasses' . DIRECTORY_SEPARATOR . 'Renderer' . PATH_SEPARATOR
					. ROOT_PATH . DIRECTORY_SEPARATOR . 'Modules' . DIRECTORY_SEPARATOR . 'Home' . DIRECTORY_SEPARATOR . 'Common' .  PATH_SEPARATOR
					. ROOT_PATH . DIRECTORY_SEPARATOR . 'Modules' . DIRECTORY_SEPARATOR . 'Home' . DIRECTORY_SEPARATOR . 'Common' .  DIRECTORY_SEPARATOR . 'Controller' . PATH_SEPARATOR
					. ROOT_PATH . DIRECTORY_SEPARATOR . 'Modules' . DIRECTORY_SEPARATOR . 'Home' . DIRECTORY_SEPARATOR . 'Common' .  DIRECTORY_SEPARATOR . 'Model' . PATH_SEPARATOR
					. ROOT_PATH . DIRECTORY_SEPARATOR . 'Modules' . DIRECTORY_SEPARATOR . 'Home' . DIRECTORY_SEPARATOR . 'Common' .  DIRECTORY_SEPARATOR . 'View' . PATH_SEPARATOR;
	set_include_path($include_path);
	//echo get_include_path();

	$file_path = ucfirst($className).'.class.php';
	
	if (!include_once($file_path))
		echo 'Failed to load class <b style=\'color:red\'>\''.$className.'\'</b> automatically at <b>\''.$file_path.'\'</b>.<br />';
}

?>