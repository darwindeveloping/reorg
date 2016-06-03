<?php
/**
 * Created by PhpStorm.
 * User: darsal
 * Date: 5/30/16
 * Time: 5:21 PM
 */

require_once 'index.php';

class JsonController {

    public function getAll(){
        $filters = '';

        $options = [
            'length' => $_POST[ 'length'],
            'start' =>  $_POST[ 'start'],
        ];

        if( !empty( $_POST[ 'search'] ) ){
            $options[ 'search' ] = filter_var( $_POST[ 'search'], FILTER_SANITIZE_STRING );
        }

        $lmTable = new lunchMoneyTable();

        $result[ 'data']  =  $lmTable->getAll( $options );
        $result[ 'total' ] = count( $result[ 'data' ]);
//        $result[ 'total'] = $lmTable->getTotalCount($options );

        return $result;
    }
}