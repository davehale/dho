<?php
namespace dho\cms\HtmlElements;
/**
 *
 * @author dave
 *        
 *        
 */

abstract class GlobalAttributes {
	
	
	
	/**
	 * specifies this instance id
	 * @var int
	 */
	protected $instanceID;
	/**
	 * Specifies a shortcut key to activate/focus an element
	 *
	 * @var string
	 * @example &lt;a href="http://www.w3schools.com/css3"
	 *          accesskey="c">CSS3</a>
	 * @link http://www.w3schools.com/tags/att_global_accesskey.asp
	 */
	protected $accesskey;
	
	/**
	 * Specifies one or more classnames for an element (refers to a class in a
	 * style sheet)
	 *
	 * @var string
	 * @example <h1 class="intro">Header 1</h1>
	 * @link http://www.w3schools.com/tags/att_global_class.asp
	 */
	protected $class;
	/**
	 * specifies whether the content of an element is editable or not
	 *
	 * @var string
	 * @example &lt;element contenteditable="true|false">
	 * @link http://www.w3schools.com/tags/att_global_contenteditable.asp
	 *      
	 */
	protected $contenteditable; 
	
	/**
	 * <center><h1>no browser support yet</h1></center>
	 *
	 * Specifies a context menu for an element. The context menu appears when a
	 * user right-clicks on the element
	 *
	 * @var string
	 *
	 */
	protected $contextmenu;
	/**
	 * Used to store custom data private to the page or application
	 *
	 * @var string
	 * @example <code><br/>&lt;ul><br/>
	 *          &lt;li data-animal-type="bird">Owl&lt;/li><br/>
	 *          &lt;li data-animal-type="fish">Salmon&lt;/li><br/>
	 *          &lt;li data-animal-type="spider">Tarantula&lt;/li><br/>
	 *          &lt;/ul><br/> </code>
	 * @link http://www.w3schools.com/tags/att_global_data.asp
	 */
	protected $data;
	
	/**
	 * Specifies the text direction for the content in an element
	 *
	 * @var string
	 * @example <code>&lt;element dir="ltr|rtl|auto"></code><br/>
     *  <code>&lt;p dir="rtl">Write this text right-to-left!&lt;/p> </code>
	 * @link http://www.w3schools.com/tags/att_global_dir.asp
	 */
	protected $dir;
	/**
	 * Specifies whether an element is draggable or not
	 * 
	 * @var string
	 * @example <code></code>
	 * @link http://www.w3schools.com/tags/att_global_draggable.asp
	 */
	protected $draggable;
	/**
	 * Specifies whether the dragged data is copied moved or linked when dropped
	 *
	 * @var string
	 * @example <code></code>
	 * @link http://www.w3schools.com/tags/att_global_dropzone.asp
	 */
	protected $dropzone;
	/**
	 * Specifies that an element is not yet; or is no longer relevant
	 *
	 * @var string
	 * @example <code></code>
	 * @link http://www.w3schools.com/tags/att_global_hidden.asp
	 */
	protected $hidden;
	/**
	 * Specifies a unique id for an element
	 *
	 * @var string
	 * @example <code></code>
	 * @link http://www.w3schools.com/tags/att_global_id.asp
	 */
	protected $id;
	/**
	 * Specifies the language of the element's content
	 *
	 * @var string
	 * @example <code></code>
	 * @link http://www.w3schools.com/tags/att_global_lang.asp
	 */
	protected $lang;
	/**
	 * Specifies whether the element is to have its
	 * spelling and grammar checked or not
	 *
	 * @var string
	 * @example <code></code>
	 * @link http://www.w3schools.com/tags/att_global_spellcheck.asp
	 */
	protected $spellcheck;
	/**
	 * Specifies an inline CSS style for an element
	 *
	 * @var string
	 * @example <code></code>
	 * @link http://www.w3schools.com/tags/att_global_style.asp
	 */
	protected $style;
	/**
	 * Specifies the tabbing order of an element
	 *
	 * @var string
	 * @example <code></code>
	 * @link http://www.w3schools.com/tags/att_global_dir.asp
	 */
	protected $tabindex;
	/**
	 * Specifies extra information about an element
	 *
	 * @var string
	 * @example <code>&lt;p title="Free Web
	 *          tutorials">W3Schools.com&lt;/p></code>
	 * @link http://www.w3schools.com/tags/att_global_tabindex.asp
	 */
	protected $title;
	/**
	 * Specifies whether an element's value are to be translated when the page
	 * is localized; or not.
	 *
	 * @var string
	 * @example <code></code>
	 * @link http://www.w3schools.com/tags/att_global_title.asp
	 */
	protected $translate;
	
	function __construct() {
	
	}
	/**
	 *
	 * @return the $accesskey
	 */
	protected function getAccesskey() {
		return $this->accesskey;
	}
	
	/**
	 *
	 * @return the $class
	 */
	protected function getClass() {
		return $this->class;
	}
	
	/**
	 *
	 * @return the $contenteditable
	 */
	protected function getContenteditable() {
		return $this->contenteditable;
	}
	
	/**
	 *
	 * @return the $contextmenu
	 */
	protected function getContextmenu() {
		return $this->contextmenu;
	}
	
	/**
	 *
	 * @return the $data
	 */
	protected function getData() {
		return $this->data;
	}
	
	/**
	 *
	 * @return the $dir
	 */
	protected function getDir() {
		return $this->dir;
	}
	
	/**
	 *
	 * @return the $draggable
	 */
	protected function getDraggable() {
		return $this->draggable;
	}
	
	/**
	 *
	 * @return the $dropzone
	 */
	protected function getDropzone() {
		return $this->dropzone;
	}
	
	/**
	 *
	 * @return the $hidden
	 */
	protected function getHidden() {
		return $this->hidden;
	}
	
	/**
	 *
	 * @return the $id
	 */
	protected function getId() {
		return $this->id;
	}
	
	/**
	 *
	 * @return the $lang
	 */
	protected function getLang() {
		return $this->lang;
	}
	
	/**
	 *
	 * @return the $spellcheck
	 */
	protected function getSpellcheck() {
		return $this->spellcheck;
	}
	
	/**
	 *
	 * @return the $style
	 */
	protected function getStyle() {
		return $this->style;
	}
	
	/**
	 *
	 * @return the $tabindex
	 */
	protected function getTabindex() {
		return $this->tabindex;
	}
	
	/**
	 *
	 * @return the $title
	 */
	protected function getTitle() {
		return $this->title;
	}
	
	/**
	 *
	 * @return the $translate
	 */
	protected function getTranslate() {
		return $this->translate;
	}
	
	/**
	 *
	 * @param $accesskey field_type       	
	 */
	protected function setAccesskey($accesskey) {
		$this->accesskey = $accesskey;
	}
	
	/**
	 *
	 * @param $class field_type       	
	 */
	protected function setClass($class) {
		$this->class = $class;
	}
	
	/**
	 *
	 * @param $contenteditable field_type       	
	 */
	protected function setContenteditable($contenteditable) {
		$this->contenteditable = $contenteditable;
	}
	
	/**
	 *
	 * @param $contextmenu field_type       	
	 */
	protected function setContextmenu($contextmenu) {
		$this->contextmenu = $contextmenu;
	}
	
	/**
	 *
	 * @param $data field_type       	
	 */
	protected function setData($data) {
		$this->data = $data;
	}
	
	/**
	 *
	 * @param $dir field_type       	
	 */
	protected function setDir($dir) {
		$this->dir = $dir;
	}
	
	/**
	 *
	 * @param $draggable field_type       	
	 */
	protected function setDraggable($draggable) {
		$this->draggable = $draggable;
	}
	
	/**
	 *
	 * @param $dropzone field_type       	
	 */
	protected function setDropzone($dropzone) {
		$this->dropzone = $dropzone;
	}
	
	/**
	 *
	 * @param $hidden field_type       	
	 */
	protected function setHidden($hidden) {
		$this->hidden = $hidden;
	}
	
	/**
	 *
	 * @param $id field_type       	
	 */
	protected function setId($id) {
		$this->id = $id;
	}
	
	/**
	 *
	 * @param $lang field_type       	
	 */
	protected function setLang($lang) {
		$this->lang = $lang;
	}
	
	/**
	 *
	 * @param $spellcheck field_type       	
	 */
	protected function setSpellcheck($spellcheck) {
		$this->spellcheck = $spellcheck;
	}
	
	/**
	 *
	 * @param $style field_type       	
	 */
	protected function setStyle($style) {
		$this->style = $style;
	}
	
	/**
	 *
	 * @param $tabindex field_type       	
	 */
	protected function setTabindex($tabindex) {
		$this->tabindex = $tabindex;
	}
	
	/**
	 *
	 * @param $title field_type       	
	 */
	protected function setTitle($title) {
		$this->title = $title;
	}
	
	/**
	 *
	 * @param $translate field_type       	
	 */
	protected function setTranslate($translate) {
		$this->translate = $translate;
	}

}




