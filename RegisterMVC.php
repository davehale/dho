<?php
use dho\mvc\autoloaders\BasicAutoloader;

// define dho directories
defined ( 'DOC_ROOT' ) || define ( 'DOC_ROOT', dirname ( $_SERVER ['DOCUMENT_ROOT'] ) . "/" );
defined ( 'DHO_BASE' ) || define ( 'DHO_BASE', (DOC_ROOT . "dho/" ));
defined ( "DHO_LOGS" ) || define ( "DHO_LOGS", (DOC_ROOT . "dho_logs/") );

// define domain root url
defined ( 'URL_BASE' ) || define ( 'URL_BASE', 'http://' . $_SERVER ['SERVER_NAME'] . "/" );


// define website apps directories
defined ( 'WEBSITE_MVC_DIR' ) || define ( 'WEBSITE_MVC_DIR',( DOC_ROOT . 'website_mvc_dir/') );
defined ( "WEBSITE_MODULE_FOLDER" ) || define ( "WEBSITE_MODULE_FOLDER", (WEBSITE_MVC_DIR . "modules/" ));
defined ( "WEBSITE_TEMPLATE_FOLDER" ) || define ( "WEBSITE_TEMPLATE_FOLDER", (WEBSITE_MVC_DIR . "templates/") );

// define mvc url defaults
defined ( 'DEFAULT_CONTROLLER_NAME' ) || define ( 'DEFAULT_CONTROLLER_NAME', "IndexController" );
defined ( 'DEFAULT_MODULE_NAME' ) || define ( 'DEFAULT_MODULE_NAME', "" );
defined ( 'DEFAULT_ACTION_NAME' ) || define ( 'DEFAULT_ACTION_NAME', 'index' );
defined ( 'DEFAULT_LANGUAGE' ) || define ( 'DEFAULT_LANGUAGE', 'en' );

// set up error reporting
defined ("ERROR_REPORTING")|| define ( 'ERROR_REPORTING', 'on' );

// default php autoloader
spl_autoload_extensions ( ".php" );
spl_autoload_register ();


require_once (dirname ( $_SERVER ['DOCUMENT_ROOT'] ) . '/dho/mvc/autoloaders/BasicAutoloader.php');
// register autoloader
BasicAutoloader::register ( array ("DOC_ROOT" => DOC_ROOT ), FALSE );
// re-register but with recursive dir scan - allows main paths above to be first
// in path
BasicAutoloader::register ( array ("URL_BASE" => URL_BASE, "DHO_BASE" => DHO_BASE,  "WEBSITE_MVC_DIR" => WEBSITE_MVC_DIR ), TRUE ); 

