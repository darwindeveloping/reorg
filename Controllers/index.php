<?php
/**
 * Created by PhpStorm.
 * User: darsal
 * Date: 5/29/16
 * Time: 1:04 AM
 */
require_once dirname( dirname( __FILE__ ) ).'/includes/configs.php';

function  my_autoload( $class ){
    require_once MODELS_DIR.'/'.$class.'.php';
}

spl_autoload_register( 'my_autoload' );


