<?php
namespace dho\cms\HtmlElements;



class Anchor extends GlobalAttributes {
	
	
	/**
	 * Specifies the URL of the page the link goes to
	 * 
	 * @var string
	 */
	protected $href;
	/**
	 * Specifies the language of the linked document
	 * 
	 * @var string
	 */
	protected $hreflang;
	/**
	 * Specifies what media/device the linked document is optimized for
	 * 
	 * @var string
	 */
	protected $media;
	/**
	 * Specifies the relationship between the current document and the linked document
	 * 
	 * @var string
	 */
	protected $rel;
	
	/**
	 * Specifies where to open the linked document
	 *  
	 * @example &lt;a target="_blank|_self|_parent|_top|framename">
	 * @var string
	 * @link &lt;a rel="value"> 
	 */
	protected $target;
	/**
	 * Specifies the MIME type of the linked document
	 * 
	 * @var string
	 * @example &lt;a type="MIME_type">
	 * @link http://www.w3schools.com/tags/att_a_type.asp
	 */
	protected $type;
	
	/**
	 * Specifies the onpage link text
	 *
	 * @var string $anchorText
	 */
	protected $anchorText;
	
	

	

	/**
	 * @return the $href
	 */
	public function getHref() {
		return $this->href;
	}

	/**
	 * @return the $hreflang
	 */
	public function getHreflang() {
		return $this->hreflang;
	}

	/**
	 * @return the $media
	 */
	public function getMedia() {
		return $this->media;
	}

	/**
	 * @return the $rel
	 */
	public function getRel() {
		return $this->rel;
	}

	/**
	 * @return the $target
	 */
	public function getTarget() {
		return $this->target;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return the $anchorText
	 */
	public function getAnchorText() {
		return $this->anchorText;
	}

	/**
	 * @param string $href
	 */
	public function setHref($href) {
		$this->href = $href;
	}

	/**
	 * @param string $hreflang
	 */
	public function setHreflang($hreflang) {
		$this->hreflang = $hreflang;
	}

	/**
	 * @param string $media
	 */
	public function setMedia($media) {
		$this->media = $media;
	}

	/**
	 * @param string $rel
	 */
	public function setRel($rel) {
		$this->rel = $rel;
	}

	/**
	 * @param string $target
	 */
	public function setTarget($target) {
		$this->target = $target;
	}

	/**
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @param string $anchorText
	 */
	public function setAnchorText($anchorText) {
		$this->anchorText = $anchorText;
	}

	function __construct(
			$anchorText="Click Me",
			$href=URL_BASE,
			$rel="INDEX,FOLLOW",
			$target="_self",
			$type="text/html",
			$hreflang="en",
			$media="screen") {
	
		$this->anchorText=$anchorText;
		$this->href=$href;
		$this->rel=$rel;
		$this->target=$target;
		$this->type=$type;
		$this->hreflang=$hreflang;
		$this->media=$media;
		
	}
	
	public function show(){
		echo $this->getHtml();
	}
	public function getHtml(){
		ob_start();
	echo"
	<a 
	href=\"$this->href\"	
	rel=\"$this->rel\"  
	target=\"$this->target\" 
	type=\"$this->type\" 
	hreflang=\"$this->hreflang\" 
	media=\"$this->media\"
	>
	$this->anchorText
	</a>";
	return ob_get_clean();
	}
	
}

?>