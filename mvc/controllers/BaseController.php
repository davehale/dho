<?php

namespace dho\mvc\controllers;

use dho\mvc\classes\Request;
use dho\mvc\classes\view;

abstract class BaseController {
	public $link_to_frontController;
	public $request;
	protected $view;
	//protected $webRoot = WEBROOT_URL;
	public function __construct() {
		$this->view = new view ( $this );
	}
	public function dispatch(Request $req, $frontController) {
		$this->request = $req;
		$this->link_to_frontController = $frontController;
		call_user_func_array ( array (
				$this,
				$this->request->_action ['action'] 
		), $this->request->_action ['paramaters'] );
	}
	public function route($url) {
		$routeResult=null;
		
		ob_start ();
		
		$this->link_to_frontController->run ( $url );
		
		$routeResult = ob_get_contents();
		ob_end_clean();
		return $routeResult;
	}
}

