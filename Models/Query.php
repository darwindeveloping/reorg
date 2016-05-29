<?php
/**
 * Created by PhpStorm.
 * User: darsal
 * Date: 5/28/16
 * Time: 11:09 PM
 */

namespace Models;

use PDO;
use Exception;

class Query {
    protected $_mSelect;
    protected $_mTable;
    protected $_mQuery;
    protected $_mType;
    protected $_mLimit;
    protected $_mOffset;
    protected $_mColumns;

    public function __construct(){
        $this->_mSelect = '';
        $this->_mTable = '';
        $this->_mQuery = '';
        $this->_mType = '';
        $this->_mOffset = 0;
        $this->_mLimit = '';
    }

    public function select(){
        $this->_mType = 'select';

        return $this;
    }

    public function from( $table ){
        $this->_mTable = $table;

        return $this->_mTable;
    }

    public function getStatement(){
        switch( $this->_mType ){
            case 'select':
                return $this->getSelectStatement();
                break;
            case 'insert':
                return $this->getInsertStatement();
                break;
            case 'update':
                return $this->getUpdateStatement();
                break;
            case 'delete':
                return $this->getDeleteStatement();
                break;
            default:
                throw new \Exception( 'Your query type, '.$this->_mType.' is not supported' );
        }
    }

    public function limit( $limit ){
        $this->_mLimit = $limit;

        return $this;
    }

    public function offset( $offset ){
        $this->_mOffset = $offset;

        return $this;
    }

    public function getSelectStatement(){
        $this->_mQuery = 'Select ';

        $this->_mQuery = !empty( $this->_mColumns )?$this->getColumns():'*';

        $this->_mQuery .= ' FROM '.$this->getTable();

        if( !empty( $this->_mWhere ) ){
            $this->mQuery .= 'WHERE '
        }
        if( !empty( $this->getLimit() ) ){
            $this->_mQuery .= 'LIMIT '.$this->getLimit();
        }

        $this->_mQuery .= 'OFFSET '.$this->getOffset();
    }

    public function getLimit(){
        return $this->_mLimit;
    }

    public function getOffset(){
        return $this->_mOffset;
    }

    public function getColumns(){
        $result = '';

        foreach( $this->_mColumns AS $column => $name ){
            $result .= $column.' AS '.$name.', ';
        }

        return rtrim( $result, ',' );
    }

    public function execute(){
        try {
            $this->_mHandler = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => DB_PERSISTENCY));

            //set PDO to acccept exceptions
            $this->_mHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        }catch( \Exception $e ){
            echo $e->getMessage().PHP_EOL;
        }

    }
}