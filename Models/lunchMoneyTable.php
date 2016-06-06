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
                            recipient_primary_business_street_address_line1,
                            recipient_primary_business_street_address_line2,
                            recipient_city,
                            recipient_state,
                            recipient_zip_code,
                            name_of_associated_covered_drug_or_biological1,
                            name_of_associated_covered_drug_or_biological2,
                            name_of_associated_covered_drug_or_biological3,
                            name_of_associated_covered_drug_or_biological4,
                            name_of_associated_covered_drug_or_biological5,
                            ndc_of_associated_covered_drug_or_biological1,
                            ndc_of_associated_covered_drug_or_biological2,
                            ndc_of_associated_covered_drug_or_biological3,
                            ndc_of_associated_covered_drug_or_biological4,
                            ndc_of_associated_covered_drug_or_biological5,
                            name_of_associated_covered_device_or_medical_supply1,
                            name_of_associated_covered_device_or_medical_supply2,
                            name_of_associated_covered_device_or_medical_supply3,
                            name_of_associated_covered_device_or_medical_supply4,
                            name_of_associated_covered_device_or_medical_supply5
                            )
                    AGAINST( :search IN BOOLEAN MODE)';

        return dbHandler::getAll( $sql, array( ':search' => $options[ 'search']) );
    }

    public function exist( $row ){
        $sql = 'SELECT
                  *
                FROM '.$this->getTable().'
                WHERE record_id = :record_id';

        $result  = dbHandler::getOne( $sql, array(
            ':record_id' => $row[ 'record_id'],
        ) );

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