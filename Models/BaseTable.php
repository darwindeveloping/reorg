<?php
/**
 * Created by PhpStorm.
 * User: darsal
 * Date: 5/28/16
 * Time: 11:01 PM
 */

//namespace Models;

class BaseTable {
    protected $_mTable;
    public function __construct( $table ){
        $this->_mTable = $table;
    }
    public function get( array $options = [] ){
        $options += [
            'limit' => 50,
            'offset' => 0,
        ];

        $pdo = new PDOHandler();

//        $result = $select->execute();
    }

    public function getAll(){

    }

    public function getTable(){
        return $this->_mTable;
    }

    public function add( $row ){
        $parameters = $this->getParameters($row );

        dbHandler::Execute(
            'INSERT INTO '.$this->getTable().'( '.implode( ',', array_keys( $row ) ).' ) VALUES('.implode( ',', array_keys( $parameters ) ).' )',
             $parameters );
    }

    protected function getParameters( array $row = []){
        $result = [];
        foreach( $row AS $parameter => $value ){
            $result[ ':'.$parameter ] = $value;
        }

        return $result;
    }
}