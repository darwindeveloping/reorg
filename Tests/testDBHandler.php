<?php
/**
 * Created by PhpStorm.
 * User: darsal
 * Date: 5/29/16
 * Time: 12:49 AM
 */

//namespace Tests;

//use reorg\Models\databaseHandler;

require_once 'index.php';

print_r(  dbHandler::getAll('select * from doctor_lunch_money' ) );
