<?php

namespace dho\mvc\classes;

class View {
	public $template_Variable_Array = array ();
	public $contentArray = array ();
	public $asideArray = array ();
	
	public $template_CSS_Array = array ();
	public $templateFile;
	public $controllerRef;
	public function __construct($callingObj) {
		$this->controllerRef = $callingObj;
	}
	
	//new 
		public function extractBrowserTitle() {
		$browserTitle = null;
		 $browserTitle =(
		  ((isset($this->contentArray ['pageTitle']) )? $this->contentArray ['pageTitle'] :
		   (( isset($this->contentArray ['subTitle'])) ? $this->contentArray ['subTitle'] : APPLICATION_NAME)));
		return $browserTitle ;
	}
	
	public function assignAsideContent($sectionIDName, $value) {
		if (isset ( $this->asideArray [$sectionIDName] )) {
			$this->asideArray [$sectionIDName] = $this->asideArray [$sectionIDName] . $value;
		} else {
			$this->asideArray [$sectionIDName] = $value;
		}
	}
	public function replaceAsideContent($sectionIDName, $value) {
		if (isset ( $this->asideArray [$sectionIDName]) && isset($value)) {
			$this->asideArray [$sectionIDName] = $value;
		}
	}
	
	
	/**
	 * jjjj
	 * 
	 * @param string $sectionIDName
	 *        	name of the id class added to the html section tag
	 * @param string $value
	 *        	string containing the html to add to contents of the section for $sectionIDName
	 */
	public function assignSectionContent($sectionIDName, $value) {
		if (isset ( $this->contentArray [$sectionIDName] )) {
			$this->contentArray [$sectionIDName] = $this->contentArray [$sectionIDName] . $value;
		} else {
			$this->contentArray [$sectionIDName] = $value;
		}
	}
	public function replaceSectionContent($sectionIDName, $value) {
		if (isset ( $this->contentArray [$sectionIDName]) && isset($value)) {
			$this->contentArray [$sectionIDName] = $value;
		} 
	}
	
	public function assign($varName, $value) {
		$this->template_Variable_Array [$varName] = $value;
	}
	
	

	
	
	public function injectFromUrl($url) {
		return $this->controllerRef->route ( $url );
	}
	public function injectTemplate($componentTemplateFile) {
		self::show ( $componentTemplateFile );
	}
	private function findTemplatePath($componentTemplateFile) {
		switch (true) {
			
			// current dir
			case file_exists ( $componentTemplateFile . '.tpl.php' ) :
				break;
			
			// template directory in the module directory where current in action controller lives
			// document root / application dir name / modules/module direcotry name /templates/main.tpl.php
			case file_exists ( $this->controllerRef->request->_module_path . '/templates/' . $componentTemplateFile . '.tpl.php' ) :
				$componentTemplateFile = $this->controllerRef->request->_module_path . '/templates/' . $componentTemplateFile . '.tpl.php';
				break;
			
			// applications main templates dir - one which will prob be made 'enforced' to use??
			case file_exists ( WEBSITE_TEMPLATE_FOLDER .  $componentTemplateFile . '.tpl.php' ) :
				$componentTemplateFile = WEBSITE_TEMPLATE_FOLDER .  $componentTemplateFile . '.tpl.php';
				break;
			
			/* // frameworks template dir
			case file_exists ( DHO_MVC . 'templates/' . $componentTemplateFile . '.tpl.php' ) :
				$componentTemplateFile = DHO_MVC . 'templates/' . $componentTemplateFile . '.tpl.php';
				break; */
				case file_exists ( WEBSITE_TEMPLATE_FOLDER . 'page templates/' . $componentTemplateFile . '.tpl.php' ) :
					$componentTemplateFile = WEBSITE_TEMPLATE_FOLDER . 'page templates/' . $componentTemplateFile . '.tpl.php';
					break;
			default :
				trigger_error ( "template \"$componentTemplateFile.tpl.php\" not found  used in " . $this->controllerRef->request->_module_path . '/' . get_class ( $this->controllerRef ) . '.php' );
				$componentTemplateFile = null;
				break;
		}
		return $componentTemplateFile;
	}
	public function addComponentTemplateToView($templateToken, $componentTemplateFile) {
		$componentTemplateFile = self::findTemplatePath ( $componentTemplateFile );
		self::replaceTokens ( $componentTemplateFile );
		if (isset ( $componentTemplateFile )) {
			$html = self::replaceTokens ( $componentTemplateFile );
			
			self::assign ( $templateToken, $html );
		}
	}
	private function setTemplatePath($template) {
		$this->templateFile = self::findTemplatePath ( $template );
	}
	
	/**
	
	 *
	 * @param unknown $varname        	
	 * @return Ambigous <string, multitype:>
	 *         in template file use $this->tokenName to grab conent which shows "undefined placeholder $varName";
	 *         or simply use $tokenName which will trow user notice if not found
	 *        
	 */

	public function showSectionContent($sectionTemplate, $section = 'all') {
		$this::setTemplatePath ( $sectionTemplate );
		foreach ( $this->contentArray as $key => $value ) {
			if ($section === 'all' || $section === $key) {
				$this->sectionId = $key;
				$this->sectionContent = $value;
				ob_start ();
				include $this->templateFile;
				$html = ob_get_clean ();
				echo $html;
			}
		}
	}
	
	
	public function showAsideContent($sectionTemplate, $section = 'all') {
		$this::setTemplatePath ( $sectionTemplate );
		foreach ( $this->asideArray as $key => $value ) {
			if ($section === 'all' || $section === $key) {
				$this->sectionId = $key;
				$this->sectionContent = $value;
				ob_start ();
				include $this->templateFile;
				$html = ob_get_clean ();
				echo $html;
			}
		}
	}
	
	
	
//need
	public function show($template) {
		$this::setTemplatePath ( $template );
		self::replaceTokens ( $this->templateFile, $this->template_Variable_Array );
		self::replaceTokens ( $this->templateFile, $this->contentArray );
		
		ob_start ();
		include $this->templateFile;
		$html = ob_get_clean ();
		
		echo $html;
		return $html;
	}
	private function replaceTokens($template, $tokenAndValuesArray) {
		foreach ( $tokenAndValuesArray as $key => $value ) {
			$this->$key = $value;
			$$key = $value;
		}
	}
}