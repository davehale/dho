<?php
namespace dho\cms\HtmlElements;



class Anchor extends GlobalAttributes {
	
	/**
	 * holds total anchor id count
	 * @var static int
	 */
	  public static $counter = 0;
	/**
	 * specifies this instance id
	 * @var int
	 */
	protected $instanceID;
	/**
	 * specifies this anchors parentID
	 * @var int
	 */
	protected $parentID;
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
		
		 $this->id = ++self::$counter;
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