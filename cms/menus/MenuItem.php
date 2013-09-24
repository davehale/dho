<?php
namespace dho\cms\menus;

use dho\cms\HtmlElements\Anchor;

class MenuItem {
	
	protected $_parents = array ();
	protected $anchor;
	protected $anchorName;
	function __construct($anchor = NULL, $name = NULL, $parents = NULL) {
		
		echo $this->addAnchor ( $anchor, $name );
		$this->addName ( $name );
		$this->addparents ( $parents );
	
	}
	
	public function addAnchor($anchor = NULL, $name = NULL) {
		if (! $anchor instanceof Anchor && $name != NULL) {
			$this->anchor = new Anchor ( $name );
		} elseif ($anchor instanceof Anchor) {
			$this->anchor = $anchor;
		} else return FALSE;
	}
	public function addName($name = NULL) {
		// anchorName set to passed in name or defaults to the anchorText
		if (isset ( $name )) {
			$this->anchorName = $name;
		} elseif ($this->anchor instanceof Anchor) {
			$this->anchorName=$this->anchor->getAnchorText ();
		}
	}

	
	/**
	 * add single parent by a named string or array(+nested) of strings to
	 * this menuitem instance
	 * 
	 * @param $parents unknown_type       	
	 */
	public function addparents($parents = NULL) {
		if (is_array ( $parents )) {
			foreach ( $parents as $parent ){
				$this->addparents ( $parent );
			}
		}
		$this->_parents [] = $parents;
		
		
	}
}

?>