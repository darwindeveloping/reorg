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

    public function search($options){
        $sql = 'SELECT
                *
                FROM '.$this->getTable().'
                WHERE MATCH( physician_first_name,
                            physician_middle_name,
                            physician_last_name,
                            physician_license_state_code1,
                            physician_license_state_code2,
                            physician_license_state_code3,
                            physician_license_state_code4,
                            physician_license_state_code5,
                            physician_specialty,
                            physician_primary_type,
                            physician_ownership_indicator)
                    AGAINST( :search )';

        return dbHandler::getAll( $sql, array( ':search' => $options[ 'search']) );
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
        $results = array(
            'columns' => array(),
            'values' => array(),
        );

        foreach( $row AS $column => $value ){
            $results[ 'columns' ][$column] = ':'.$column;
            $results[ 'values'][ ':'.$column ] = $value;
        }

        return $results;
    }

}