<?php
/**
 * @package dho
 * @brief DHO Solutions PHP package
 * @author Dave Hale <contact@davehaleonline.com>
 * @version 1
 * @since september 2013
 * @copyright open source
 *   
 * @file   BasicAutoloader.php
 * @version 1
 * @since september 2013
 * @copyright open source
 * @section LICENSE
 * This file is part of the DHO MVC Project <http://davehaleonline.com>.
 * Copyright (C) 2011 UARX Networks.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 *
 * @namespace dho::mvc::autoloaders
 * @brief DHO MVC autoloaders package
 * @author Dave Hale <contact@davehaleonline.com>
 * @version 1
 * @since september 2013
 * @copyright open source
 */
namespace dho\mvc\autoloaders;

defined ( "DHO_LOGS" ) || define ( "DHO_LOGS", ($_SERVER ["DOCUMENT_ROOT"] . "/dho_logs/") );

/**
 * @class BasicAutoloader
 * @brief basic autoloader with definable base paths to load from.
 * 
 */
class BasicAutoloader {
	/**
	 * holds all paths to check when autoload
	 *
	 * @var string array
	 */
	private static $pathsArray; /*
	                             * !< an array of strings
	                             */
	
	/**
	 * registered autoload function
	 */
	private static function loader($className) {
		// swap \ for / for namespaces to be found on unix systems
		$className = str_replace ( "\\", "/", $className ) . '.php';
		foreach ( self::$pathsArray as $key => $path ) {
			$fullFilePath = constant ( $key ) . $className;
			
			self::log ( "trying to load class $className => " . constant ( $key ) . $className );
			if (file_exists ( $fullFilePath )) {
				self::log ( "loaded class $className" );
				require ($fullFilePath);
				break;
			}
		}
	}
	
	/**
	 * logs paths added and autoload classes looked for and found
	 *
	 * @param $msg string
	 *       	 messgae to be logged
	 */
	private static function log($msg) {
		
		if (defined ( "DHO_LOGS" ) && is_dir ( DHO_LOGS )) {
			error_log ( "(" . date ( 'm/d/Y H:i:s ', time () ) . ") ::BasicAutoloader.php:: " . $msg . PHP_EOL, 3, DHO_LOGS . "trace.log" );
			error_log ( "(" . date ( 'm/d/Y H:i:s ', time () ) . ") ::BasicAutoloader.php:: " . $msg . PHP_EOL, 3, DHO_LOGS . "autoloader.log" );
		}
	}
	
	/**
	 * @fn public static function register(array $pathsArray, $deepFill = FALSE)
	 * @brief register an autoloader with an array of base paths to scan
	 *
	 * @param $pathsArray array
	 *       	 of base paths to scan by the autoloader
	 * @param $deepFill boolean
	 *       	 if the subdirectories of the base array directories are to be
	 *       	 scanned
	 *       	
	 * @example BasicAutoloader::register
	 *          @code
	 *          BasicAutoloader::register ( array ("DOC_ROOT" => DOC_ROOT ),FALSE );
	 *          @endcode
	 *          with the path defined as a constant
	 *         
	 *          @code
	 *          BasicAutoloader::register ( array ("DOC_ROOT" => "c:/wamp/" ,
	 *          ("WEB_ROOT" => "c:/www/"), FALSE );
	 *          @endcode
	 *          or with the path as a string
	 */
	
	public static function register(array $pathsArray, $deepFill = FALSE) {
		// default php autoloader
		spl_autoload_extensions ( ".php" );
		spl_autoload_register ();
		foreach ( $pathsArray as $key => $path ) {
			// swap \ for / for namespaces to be found on unix systems
			$path = str_replace ( "\\", "/", (rtrim ( $path, '/' ) . "/") );
			if (is_dir ( $path )) {
				self::log ( "adding autoload path $path" );
				self::$pathsArray [$key] = $path;
				defined ( $key ) || define ( $key, $path );
				
				if ($deepFill == TRUE) {
					self::dirToArray ( $path );
				}
			}
		}
		spl_autoload_register ( array (__NAMESPACE__ . '\BasicAutoloader', 'loader' ) );
	}
	
	/**
	 * @fn public static function unregister()
	 * @brief unregisters the autoloader
	 *
	 * this is a static class and only one function is registered no matter how
	 * many times its register function has been called.
	 * as such this will remove all autoload paths assigned be numerous calls
	 *
	 * @example BasicAutoloader::unregister
	 *          @code BasicAutoloader::unregister(); @endcode
	 */
	public static function unregister() {
		
		@spl_autoload_unregister ( array (__NAMESPACE__ . '\BasicAutoloaders', 'loader' ) );
	
	}
	/**
	 * Add directories recursively
	 *
	 * @param $dir string
	 *       	 the directory path currently being scanned
	 */
	private static function dirToArray($dir) {
		foreach ( scandir ( $dir ) as $node ) {
			// Skip links to current and parent folder
			if ($node == '.' || $node == '..') {
				continue;
			}
			$path = str_replace ( array ("/\\", "\\\\", "\\", "//" ), "/", $dir . DIRECTORY_SEPARATOR . $node . DIRECTORY_SEPARATOR );
			
			if (is_dir ( $path )) {
				self::$pathsArray [$path] = $path;
				self::log ( "adding autoload path $path" );
				// recursive scan dir
				self::dirToArray ( $path );
			
			}
		}
		return;
	}

}
