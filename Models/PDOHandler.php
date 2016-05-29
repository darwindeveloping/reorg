<?php

//namespace Models;

/*use Exception;
use PDOException;
use PDO;*/

class PDOHandler{
	public $mSQL;
	public $_mParameters;
	private $_mHandler = null;
	private $_mStatementHandler = null;
	
	public function __construct( $mP = array() ){

		$this->initPDO();
		
		if( isset( $mP[ 'sql' ] ) ){
            $this->setSQL( $mP[ 'sql' ] );
        }

		if( isset( $mP[ 'parameter' ] )  && !is_null( $mP[ 'parameter' ] ) ){
            $this->setParameters( $mP[ 'parameter' ] );
        }
	}
	
	private function initPDO(){
		try {
            $this->_mHandler = new PDO( PDO_DSN, DB_USERNAME, DB_PASSWORD, array( PDO::ATTR_PERSISTENT => DB_PERSISTENCY ) );
			
			//set PDO to acccept exceptions
			$this->_mHandler->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch( PDOException $e ) {
			echo $e->getMesage().PHP_EOL;
			$this->close();
			trigger_error( $e->getMessage(), E_USER_ERROR );
		}catch( Exception $e ){
            echo $e->getMessage().PHP_EOL;
            $this->close();
        }
	}
	
	public function setParameters( $mP ){
		if( !is_array( $mP ) ) {
			trigger_error( 'You need provide an array as a parameter in the function set parameters', E_USER_ERROR );
			return;
		}
		if( empty( $mP ) ){
                return;
        }

		$this->_mParameters = $mP;
	}
	
	public function setSQL( $sql ){
		if( empty( $sql ) ){
            trigger_error( 'You need to provide a sql statement to set the sql', E_USER_ERROR );
        }

		$this->mSQL = $sql;
	}
		
	public function execute( ){
		if( $this->hasErrors() ){
            trigger_error( 'There are errors on your parameters', E_USER_ERROR );
        }

		try {
			$this->_mStatementHandler = $this->_mHandler->prepare( $this->mSQL );
		
			return $this->_mStatementHandler->execute( $this->_mParameters );
		} catch( PDOException $e ) {
			echo  $e->getMessage().PHP_EOL;
		}
	}
	
	public function getAll(){
		$this->execute();
		
		return $this->_mStatementHandler->fetchAll( PDO::FETCH_ASSOC );
	}
	
	public function getLastID(){
		$new = new PDOHandler( array( 'sql' => 'SELECT LAST_INSERT_ID()', 'parameter' => array() ) );
		return $new->getOne();
	}
	
	public function getOne(){
		$this->execute( );
		
		$row = $this->_mStatementHandler->fetch( PDO::FETCH_NUM );
		
		return $row[ 0 ];
	}
	
	public function getRow(){
		$this->execute( );
		
		return $this->_mStatementHandler->fetch( PDO::FETCH_ASSOC );
	}
	
	public function close(){
		$this->_mHandler = null;
		$this->_mStatementHandler = null;
	}

	public function hasErrors(){
		return false;
	}
}
