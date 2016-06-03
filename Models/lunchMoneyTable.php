<?php
/**
 * Created by PhpStorm.
 * User: darsal
 * Date: 5/28/16
 * Time: 11:00 PM
 */

//namespace Models;

class lunchMoneyTable extends BaseTable{
    public function __construct(){
        parent::__construct( 'doctor_lunch_money' );
    }


    public function exist( $row ){
        $sql = 'SELECT
                  *
                FROM '.$this->getTable().'
                WHERE record_id = :record_id';

        $result  = dbHandler::getOne( $sql, [
            ':record_id' => $row[ 'record_id'],
        ] );

        if( empty( $result ) ){
            return false;
        }

        return true;
    }

    public function getWhereStatement($row ){
        $results = [
            'columns' => [],
            'values' => [],
        ];

        foreach( $row AS $column => $value ){
            $results[ 'columns' ][$column] = ':'.$column;
            $results[ 'values'][ ':'.$column ] = $value;
        }

        return $results;
    }

}