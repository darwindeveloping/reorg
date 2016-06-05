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
        $options = array();

        $length = filter_var( $_POST['length'], FILTER_SANITIZE_NUMBER_INT );

        if($length > 0 ){
            $options['length'] = $length;
        }

        $options['start'] = $_POST[ 'start'];

        if( !empty( $_POST[ 'search'][ 'value'] ) ){
            $options[ 'search' ] = filter_var( $_POST[ 'search'][ 'value'], FILTER_SANITIZE_STRING );
        }

        $lmTable = new lunchMoneyTable();

        $data = array();
        $total = 0;
        if( !empty( $options[ 'search'])){
            $data = $lmTable->search($options );
            $total = count( $data );
        }else{
            $data = $lmTable->getAll( $options );
            $lmTable->getTotalCount($options );
        }

        $result[ 'data']  =  $data;
        $result[ 'total'] = $total;

        return $result;
    }
}