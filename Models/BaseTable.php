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
    public function getAll(array $options = []){
        $options += [
            'length' => 50,
            'start'  => 0,
        ];

       return dbHandler::getAll(
            'SELECT * FROM '.$this->getTable().
            ' ORDER BY record_id DESC
            LIMIT  '.$options[ 'length'].
            ' OFFSET '.$options[ 'start']
        );
    }

    public function getTable(){
        return $this->_mTable;
    }

    public function add( $row ){

        if( isset( $row[ 'name_of_third_party_entity_receiving_payment_or_transfer_of_value'])){
            $value = $row[ 'name_of_third_party_entity_receiving_payment_or_transfer_of_value'];
            unset( $row[ 'name_of_third_party_entity_receiving_payment_or_transfer_of_value']);
            $row[ 'name_of_third_party_entity_receiving_payment_or_transfer_of_valu'] = $value;
        }

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