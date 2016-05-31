<?php
/**
 * Created by PhpStorm.
 * User: darsal
 * Date: 5/30/16
 * Time: 5:26 PM
 */

$filters = '';
require_once dirname( dirname( __FILE__ )).'/Controllers/JsonController.php';

$jsController = new JsonController();
$data = $jsController->getAll();
$results = [
    'draw' => $_POST[ 'draw' ],
    'recordsTotal' => count( $data ),
    'recordsFiltered' => count( $data ),
    //results
    'data' => $data
];

print_r( json_encode(  $results ) );

