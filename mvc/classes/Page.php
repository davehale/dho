<?php

namespace dho\mvc\classes;

class Page extends View{
	public $template_Variable_Array = array ();
	public $contentArray = array ();
	public $asideArray = array ();
	public $template_CSS_Array = array ();
	public $templateFile;
	public $controllerRef;
	
	protected $pageID;
	public $doctype ;
	public $favicon;
	public $meta =array();
	public $link = array();
	public $scripts = array();
	public $title;
	public $htmlLanguage;
	
	public function __construct($callingObj) {
		$this->controllerRef = $callingObj;
	}
	
	
	
	
	//todo:: can check page in db, if not in db return 404 / index
	public function __getPageID(){
	return $this->pageID;
	}
	
	// move later to view
	public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
	public function __get($varname) {
	$m='__get'.$varname;
      if(method_exists($this, $m)) return $this->$m();		
	  if (defined ( 'TEMPLATE_TOKEN_UNDEFINED_MSG' )) {
			$missingTokenMsg = str_replace ( "#", $varname, TEMPLATE_TOKEN_UNDEFINED_MSG );
		} else {
			$missingTokenMsg = "";
		}
		return isset ( $this->template_Variable_Array [$varname] ) ? $this->template_Variable_Array [$varname] : $this->template_Variable_Array [$varname] = $missingTokenMsg;
	}
	
	
	//if type=null then value === the script else its the link to script
		public function addScript( $value,$scriptType ="text/javascript") {
		
		if ($scriptType==null) {
		$this->scripts  []= "<script> $value </script>".PHP_EOL;
		} else
		{
		$this->scripts  []= "<script name = \"".$scriptType."\" src =\"".$value."\" ></script>".PHP_EOL;
		
		}
	}
	
	public function printScripts() {
	foreach ($this->scripts  as $script){
		echo $script;
		}
		
	}
	
	
	public function addCSSLink( $value,$cssGroup ="") {
		
			$this->template_CSS_Array [$cssGroup] []= "<link href=\"" . $value . "\" type=\"text/css\" rel=\"stylesheet\"/>".PHP_EOL;
		
	}
	
	
			public function addMeta( $name,$value="") {
		if ($name=="Content-Type"){
					$this->meta [$name] []= "<meta http-equiv=\"Content-Type\" content=\"".$value ."\"/>".PHP_EOL;

		} else {
			$this->meta [$name] []= "<meta name=\"" . $name . "\" content=\"".$value ."\"/>".PHP_EOL;
		}
	}
	public function printMeta() {
	foreach ($this->meta  as $group){
		foreach ($group as $link){echo $link;
		}
		
		}
		URL_BASE."images";
		echo"<link rel=\"shortcut icon\" href=\"".URL_BASE."images/".$this->favicon."\"/>".PHP_EOL;
echo"<link rel=\"icon\" href=\"".URL_BASE."images/".$this->favicon ."\"/>".PHP_EOL;
	}
	public function printCSS($css=null) {
	foreach ($this->template_CSS_Array  as $group){
		foreach ($group as $link){echo $link;}
		}
		
	}
}