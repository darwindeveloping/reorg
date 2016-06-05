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
    public function get( array $options = array() ){
        $options += array(
            'limit' => 50,
            'offset' => 0,
        );

        $pdo = new PDOHandler();

//        $result = $select->execute();
    }
    public function getTotalCount( $options ){
        $sql = 'SELECT COUNT( 0 ) AS total FROM '.$this->getTable();

        return dbHandler::getOne( $sql );
    }

    public function getAll(array $options = array()){
        $sql = 'SELECT
                *
                FROM '.$this->getTable();

     /*   if( isset( $options[ 'search '])){
            $sql .= 'WHERE '
        }
     */
        $sql .=  ' ORDER BY date_of_payment DESC ';

        if( !empty( $options[ 'length'])){
            $sql .= ' LIMIT '.$options[ 'length'].'
                        OFFSET '.$options[ 'start'];
        }



       return dbHandler::getAll( $sql );
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

    protected function getParameters( array $row = array()){
        $result = array();
        foreach( $row AS $parameter => $value ){
            $result[ ':'.$parameter ] = $value;
        }

        return $result;
    }
}