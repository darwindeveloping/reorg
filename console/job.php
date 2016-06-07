<?php
/**
 * Created by PhpStorm.
 * User: darsal
 * Date: 5/30/16
 * Time: 8:38 PM
 */

require_once dirname( dirname( __FILE__ ) ).'/includes/configs.php';

function  my_autoload( $class )
{
    require_once MODELS_DIR.'/'.$class.'.php';
}

spl_autoload_register( 'my_autoload' );

$url = 'https://openpaymentsdata.cms.gov/resource/mw4g-bs44.json';
//$ch = curl_init('https://openpaymentsdata.cms.gov/resource/mw4g-bs44.json');

//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt_array($ch, array(
    CURLOPT_SSL_VERIFYPEER => false,
    // Will return the response, if false it print the response
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_URL => $url,
    CURLOPT_FAILONERROR => true
));

if( !( $result=curl_exec($ch) ) ){
    $message = 'Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch);
    mail( 'darsal09@yahoo.com', 'Open Payment Data', $message);
    die($message);
}
curl_close($ch);

$data = json_decode($result, true);

if( empty( $data ) ){
    mail( 'darsal09@yahoo.com', 'Open Payment Data', 'Error: There was no data collected' );
    die( 'Error: There was no data collected' );
}


$lmTable = new lunchMoneyTable();

foreach( $data AS $row ){
    if( !$lmTable->exist( $row ) ){
        $lmTable->add( $row );
    }
}