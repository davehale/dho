<?php


namespace dho\mvc\controllers;
use dho\mvc\classes\Page;
abstract class PageController extends BaseController {


protected $page;


public function index(){ 
$this->page->assignSectionContent("error","page not found says pagecontroller");
$this->page->show("main");}


public function __construct(){
		parent::__construct();
				$this->page = new page ( $this );

				
		//check db for this. if none then default		
		$this->page->doctype= "html";
		$this->page->htmlLanguage =  "en_GB";
		$this->page->favicon="favicon.ico";
		
		
		$this->page->addMeta("author" ,"Dave Hale, DHO solutions, http://davehaleonline.com" );
		$this->page->addMeta("Content-Type" ,"text/html; charset=utf-8" );
		$this->page->addMeta("ROBOTS" ,"INDEX,FOLLOW");
		$this->page->addMeta("revisit-after" ,"7 days" );
		
		//todo:: add csslinks from db
		//for now default css 
		$this->page->addCSSLink(URL_BASE."/css/global.css");
		$this->page->addCSSLink(URL_BASE.'/css/'.'DHNavMenu.css');
		
		
		//		//social media scripts
		$this->page->addScript("https://apis.google.com/js/plusone.js");
		$this->page->addscript (URL_BASE.'/scripts/'."twitter.js");
		$this->page->addscript (URL_BASE.'/scripts/'."html5creates.js");
		
	}
	}
