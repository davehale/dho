<?php


namespace dho\mvc\classes;
class Request{
	
	/**
	 * @var array (country => code)
	 */
	public $_language=array();
	/**
	 * @var string path to module folder from route
	 */
	public $_module_path;
	/**
	 * @var object of controller
	 */
	public $_controller;
	/**
	 * @var array ( action => paramaters)
	 */
	public $_action =array();
	
	/**
	 * @return the $_language
	 */
	public function getLanguage() {
		return $this->_language;
	}

	/**
	 * @return the $_module_path
	 */
	public function getModule_path() {
		return $this->_module_path;
	}

	/**
	 * @return the $_controller
	 */
	public function getController() {
		return $this->_controller;
	}

	/**
	 * @return the $_action
	 */
	public function getAction() {
		return $this->_action;
	}

	

	/**
	 * @param field_type $_language
	 */
	public function setLanguage($_language) {
		$this->_language = $_language;
	}

	/**
	 * @param field_type $_module_path
	 */
	public function setModule_path($_module_path) {
		$this->_module_path = $_module_path;
	}

	/**
	 * @param field_type $_controller
	 */
	public function setController($_controller) {
		$this->_controller = $_controller;
	}

	/**
	 * @param field_type $_action
	 */
	public function setAction($_action) {
		$this->_action = $_action;
	}

	
}
	
	