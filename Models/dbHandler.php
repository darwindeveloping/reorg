<?php
//namespace Models;

//use PDO;

class dbHandler{
	//private constructor to prevent direct creation of object
	private function __construct(){}

	//Wrapper method for PDOStatement::execute()
	public static function Execute( $sqlQuery, $params = null ){
		$mP = array( 'sql' => $sqlQuery );
		
		if( $params != null ){
            $mP[ 'parameter' ] = $params;
        }

		$pdo = new PDOHandler( $mP );
		
		return $pdo->execute();		
	}
	//wrapper method for PDOStatement::fetchAll()
	public static function getAll( $sqlQuery, $params = null, $fetchStyle = PDO::FETCH_ASSOC ){
		$mP = array( 'sql' => $sqlQuery );
		
		if( $params != null )
			$mP[ 'parameter' ] = $params;
			
		$pdo = new PDOHandler( $mP );
		
		return $pdo->getAll();
	}
	//wrapper method for PDOStatement::fetch()
	public static function getRow( $sqlQuery, $params = null, $fetchStyle = PDO::FETCH_ASSOC ){
		$mP = array( 'sql' => $sqlQuery );
		
		if( $params != null ){
            $mP[ 'parameter' ] = $params;
        }

		$pdo = new PDOHandler( $mP );
		
		return $pdo->getRow();
	}

	//return the first column value from a row
	public static function getOne( $sqlQuery, $params = null ){
		$mP = array( 'sql' => $sqlQuery );
		
		if( $params != null ){
            $mP[ 'parameter' ] = $params;
        }

		$pdo = new PDOHandler( $mP );
		
		return $pdo->getOne();
		
	}
	
	public static function getLastID(){
		return self::getOne( 'SELECT LAST_INSERT_ID()' );
	}
}
