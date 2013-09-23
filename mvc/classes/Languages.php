<?php

namespace dho\mvc\classes;

define ( 'LANGS', 'french => fr,' . 'english=> en,' . 'italian=>it,' . 'spanish=>sp' );
class languages {
	function __construct() {
	}
	function __destruct() {
	}
	public static function getLanguageFromCode($country_code = null) {
		foreach ( explode ( ",", LANGS ) as $country_and_code ) {
			$temp = explode ( "=>", $country_and_code );
			$languageArray [trim ( $temp [0] )] = trim ( $temp [1] );
		}
		
		if (isset ( $country_code )) {
			$languageName = (array_search ( $country_code, $languageArray ));
		}
		
		if ($languageName == null) {
			
			$languageName = (array_search ( DEFAULT_LANGUAGE, $languageArray ));
		}
		
		return array (
				'language' => $languageName,
				'code' => $languageArray [$languageName] 
		);
	}
}

