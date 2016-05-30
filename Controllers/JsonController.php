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

        $lmTable = new lunchMoneyTable();

        return  $lmTable->getAll();
    }
}