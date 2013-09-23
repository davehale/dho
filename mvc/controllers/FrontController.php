<?php

namespace dho\mvc\controllers;

use dho\mvc\classes\languages;
use dho\mvc\classes\Request;

class FrontController {
	private $urlArray = array ();
	private $request = array ();
	private $controllerArray = array ();
	private $controller = null;
	private $module_prefix = null;
	private function init() {
		$this->request = new Request ();
		$this->controllerArray = array ();
		$this->controller = null;
		$this->module_prefix = null;
		$this->urlArray = array ();
	}
	public function __construct() {
		self::toggleErrorreporting ();
	}
	public function run($route = null) {
		self::init ();
		$this->urlArray = self::formatURL ( $route );
		
		$this->request->_language = self::setCountryCode ();
		$this->request->_module_path = self::getModulePath ();
		$this->_controller = self::loadController ();
		$this->request->_action = self::getActionArray ();
		$this->_controller->dispatch ( $this->request, $this );
		
		return;
	}
	private function loadController() {
		$controllerArray = self::buildControllerPath ();
		
try {
			
if (file_exists($controllerArray ['path'])) {
    include_once $controllerArray ['path'];
} else {
$this->run();
exit();
}
}catch (\Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";

}
		
		$controllerArray ['instance'] = class_exists ( $controllerArray ['name'] ) ? new $controllerArray ['name'] () : trigger_error ( "controller \"{$controllerArray ['name']}\" not found in \"{$controllerArray ['path']}\" " );
		$this->controllerArray = $controllerArray;
		return isset ( $controllerArray ['instance'] ) ? $controllerArray ['instance'] : null;
	}
	
	/*
	 * code below here is 'set' no need to refactor -- yet!!
	 */
	
	/**
	 * private function to check if the url supplied has an action for the given controller.
	 * if not it will check for the default action in the controller. if either are found
	 * all remaining url parts will be assumed as paramaters
	 * if no url requested or default action is found a page 404 will occur
	 *
	 * @return array (action => $action,paramaters => $params)
	 *        
	 *        
	 * @todo :: redirect to 404 page not just die();
	 *      
	 */
	private function getActionArray() {
		$action = null;
		$params = array ();
		
		$actionFromUrl = isset ( $this->urlArray [0] ) ? $this->urlArray [0] : false;
		// does the url have a possible action set
		switch ($actionFromUrl) {
			
			case true :
				// and if so is it found in the controller
				if (method_exists ( $this->_controller, $actionFromUrl )) {
					$action = $actionFromUrl;
					array_shift ( $this->urlArray );
					break;
				} else {
					// otherwise try use default action and take the remaining url parts as paramaters
					trigger_error ( " action {$actionFromUrl} not found in {$this->controllerArray['path']}: taking  {$actionFromUrl}
								as paramater and trying to use default action :: \"" . DEFAULT_ACTION_NAME . "\"" );
				}
			/*
			 * do not break after error, allow to fall through to reassign action as DEFAULT_ACTION_NAME as the possible url action was not found so break above skipped
			 */
			case false :
				// can the default action be found
				switch (method_exists ( $this->_controller, DEFAULT_ACTION_NAME )) {
					case true :
						// then use it
						$action = DEFAULT_ACTION_NAME;
						break;
					case false :
						// or effectively page 404 again as we have a controller but no default action)
						trigger_error ( "No default action \"" . DEFAULT_ACTION_NAME . "\" found in {$this->controllerArray['path']}" );
						die ();
						break;
				}
				break;
		}
		
		// what ever is left becomes paramaters
		$params = $this->urlArray;
		
		return array (
				"action" => $action,
				"paramaters" => $params 
		);
	}
	
	/**
	 * private function to look for the controller in module path and if so return it
	 *
	 * function will end script if url requested controller or default controllers
	 * not found for a url requested module
	 *
	 * @todo :: redirect to 404 page not just die();
	 *      
	 * @return array (path=> path to controller,
	 *         name=> controller name)
	 */
	private function buildControllerPath() {
		if (empty ( $this->urlArray [0] )) {
			$this->urlArray [0] = DEFAULT_ACTION_NAME;
		}
		
		$controller_path = $this->request->_module_path;
		$urlControllerFileName = $this->module_prefix . str_replace ( " ", "", (ucwords ( strtolower( $this->urlArray [0] )) )) . 'Controller.php';
		$file_to_check = $controller_path . '/' . $urlControllerFileName;
		$defaultFile_to_check = $controller_path . '/' . $this->module_prefix . DEFAULT_CONTROLLER_NAME . '.php';
		$controller_name = ucfirst ( $this->module_prefix . DEFAULT_CONTROLLER_NAME );
		
		if (file_exists ( $file_to_check )) {
			$controller_path = $controller_path . '/' . $urlControllerFileName;
			$controller_name = ucfirst ( substr ( $urlControllerFileName, 0, - 4 ) );
			array_shift ( $this->urlArray );
		} else if (file_exists ( $defaultFile_to_check )) {
			
			$msg = isset ( $this->urlArray [0] ) ? "file " . $urlControllerFileName . " not found at $controller_path. using \"{$this->urlArray [0]}\"as action  in " : "not specified.  using";
			$controller_path = $defaultFile_to_check;
			trigger_error ( "controller $msg ::  \"" . $controller_name . "\" in the file ( $defaultFile_to_check)     ", 512 );
		} else {
			/*
			 * effectively a 404 as we have no url supplied valid controller for a module or a default controller in the module folder
			 */
			$msg = $urlControllerFileName . " not found at $controller_path";
return array (
				"path" => "IndexController.php".DEFAULT_MODULE_NAME,
				"name" => DEFAULT_CONTROLLER_NAME
		);
			trigger_error ( DEFAULT_MODULE_NAME."404!!!    " . $msg . "   \"" . $controller_name . ".php\" can not be found in directory j:: <h3>$controller_path", 256 );
		}
		
		return array (
				"path" => $controller_path,
				"name" => $controller_name 
		);
	}
	
	/**
	 * scans through the class variable urlArray and builds a path through each subdirectory
	 * found untill the next array item is not a subdirectoy.
	 *
	 *
	 * @return string the path build from the class urlArray
	 *        
	 */
	private function getModulePath() {
		$module_prefix = null;
		$module_path = null;
		
		$moduleFolderPath =WEBSITE_MODULE_FOLDER;
		
		if (! is_dir ( $moduleFolderPath )) {
			trigger_error ( "no modules folder availiable at WEBSITE_MODULE_FOLDER set as " . WEBSITE_MODULE_FOLDER, 256 );
		}
		
		if (! isset ( $this->urlArray [0] )) {
			$this->urlArray [0] = DEFAULT_MODULE_NAME;
		}
		foreach ( $this->urlArray as $dirToCheck ) {
			$dirToCheck = strtolower($dirToCheck);
			if (is_dir ( $moduleFolderPath  . $dirToCheck )) {
				$moduleFolderPath = $moduleFolderPath  . $dirToCheck;
				$this->module_prefix = str_replace ( " ", "", ucwords($dirToCheck  ));
				array_shift($this->urlArray);
			}
		}
		return $moduleFolderPath;
	}
	
	/**
	 *
	 * @param string $code
	 *        	universal country code en/it/sp etc
	 * @return string of the countries language
	 */
	private function setCountryCode($code = null) {
		if (! isset ( $code )) {
			$country_code = empty ( $this->urlArray [0] ) ?  : $this->urlArray [0];
		}
		$country_code = strtolower($country_code);
		$language = languages::getLanguageFromCode ( $country_code );
		if ($language ['code'] === $country_code) {
			array_shift ( $this->urlArray );
		}
		return $language;
	}
	
	/**
	 * private class function uses ERROR_REPORTING defined
	 * in config to toggle on/off php error reports
	 *
	 * @param
	 *        	takes none
	 * @return nothing
	 */
	private function toggleErrorReporting() {
		switch (ERROR_REPORTING) {
			case 'on' :
				error_reporting ( E_ALL );
				ini_set ( "display_errors", 1 );
				if (! defined ( "TEMPLATE_TOKEN_UNDEFINED_MSG" )) {
					define ( 'TEMPLATE_TOKEN_UNDEFINED_MSG', "(undefined token #)" );
				}
				break;
			default :
				error_reporting ( 0 );
				ini_set ( "display_errors", 0 );
				if (! defined ( "TEMPLATE_TOKEN_UNDEFINED_MSG" )) {
					define ( 'TEMPLATE_TOKEN_UNDEFINED_MSG', "" );
				}
				break;
		}
	}
	
	/**
	 * change a string to array of words split by /
	 * eg formated string:: en/module/module/action/param1/param2
	 * returns array (en,module,module,action,param1,param2)
	 *
	 *
	 * @param string $route
	 *        	internally passed url
	 * @return array of url parts.
	 */
	private function formatURL($route) {
		$urlArray = null;
		if (is_null ( $route )) {
			$route = sprintf ( "%s/%s/%s", DEFAULT_LANGUAGE, DEFAULT_MODULE_NAME, DEFAULT_ACTION_NAME );
			
			if (! empty ( $_GET ['url'] )) {
				
				$route = $_GET ['url'];
			} else {
			}
		}
		// need to unset get[url] so any action chains can be routed without rereading get[url]
		unset ( $_GET ['url'] );
		$route = trim ( $route, '/\\' );
		$urlArray = explode ( "/", $route );
		$index = 0;
		
		array_walk($urlArray, function($val,$key) use(&$urlArray){
    
			 //$urlArray[$key]=ucwords(strtolower($val));
		});
		
		return $urlArray;
	}
}

