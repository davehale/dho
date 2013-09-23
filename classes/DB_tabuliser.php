<?php
namespace dho\classes;
define ( "DB_HOST", "localhost" );
define ( "DB_USER", "root" );
define ( "DB_NAME", "dho" );
define ( "DB_PASS", "wallpaper0747" );
use dho\classes\HtmlElements\Anchor;

class DB_tabuliser {
	
	protected $DBH;
	
	function __construct($className, $dbhost = null, $dbname = null, $dbuser = null, $dbpass = null) {
		$this->connectDB ( $dbhost, $dbname, $dbuser, $dbpass );
		$this->makeTable ( $className );
	}
	
	private function connectDB($dbhost = null, $dbname = null, $dbuser = null, $dbpass = null) {
		if (! isset ( $dbhost ) && defined ( "DB_HOST" )) {
			$dbhost = DB_HOST;
		} else
			new \PDOException ( "no host supplied" );
		if (! isset ( $dbname ) && defined ( "DB_NAME" )) {
			$dbname = DB_NAME;
		} else
			new \PDOException ( "no database supplied" );
		if (! isset ( $dbuser ) && defined ( "DB_USER" )) {
			$dbuser = DB_USER;
		} else
			new \PDOException ( "no user supplied" );
		if (! isset ( $dbpass ) && defined ( "DB_PASS" )) {
			$dbpass = DB_PASS;
		} else
			new \PDOException ( "no password supplied" );
		
		try {
			// MySQL Server with PDO_DBLIB
			$this->DBH = new \PDO ( "mysql:host=$dbhost;dbname=$dbname;", "$dbuser", "$dbpass" );
			$this->DBH->setAttribute ( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			$this->DBH->setAttribute ( \PDO::ATTR_EMULATE_PREPARES, false );
		
		} catch ( \PDOException $e ) {
			echo $e->getMessage ();
		}
	
	}
	private function makeTable($className) {
		try {
			$class = new \ReflectionClass ( $className );
			$props = $class->getProperties ();
			$className = substr ( $className, strrpos ( $className, '\\' ) + 1 );
		
		} catch ( \ReflectionException $e ) {
			echo $e->getMessage ();
			return false;
		}
		
		if (! $this->checkTableExists ( $className )) {
			// create table
			try {
				$q = "CREATE TABLE $className (";
				foreach ( $props as $prop ) {
					switch ($prop->getName ()) {
						case "parentID" :
						case "counter" :
							$type = " int(5)";
							break;
						case "instanceID" :
							$type = " int(5) NOT NULL AUTO_INCREMENT";
							break;
						default :
							$type = " varchar(150)";
							break;
					}
					$q .= $prop->getName () . $type . ",";
				}
				$q .= "  PRIMARY KEY (instanceID),  UNIQUE KEY id (instanceID));";
				//echo"<br/>".$q."<br/>";
				$stmt = $this->DBH->prepare ( $q );
				$stmt->execute ();
			
			} catch ( \PDOException $e ) {
				$e->getMessage ();
			}
		}
	}
	
	/**
	 * Check if a table exists in the current database.
	 *
	 *
	 * @param $table string
	 *       	 Table to search for.
	 * @param $pdo PDO
	 *       	 PDO instance connected to a database
	 * @return bool TRUE if table exists, FALSE if no table found.
	 */
	private function checkTableExists($table, $DBH = null) {
		
		if (isset ( $DBH )) {
			
			$this->DBH = $DBH;
		}
		// Try a select statement against the table
		// Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
		try {
			
			$result = $this->DBH->query ( "SELECT * FROM $table LIMIT 1" );
		} catch ( \PDOException $e ) {
			echo $e->getMessage ();
			return FALSE;
		}
		
		// Result is either boolean FALSE (no table found) or PDOStatement
		// Object (table found)
		return $result !== FALSE;
	
	}
}

?>