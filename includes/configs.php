<?php
//SITE_ROOT contains the full path to the last man standing
define( 'SITE_ROOT', dirname( dirname( __FILE__ ) ) );

//Application directories
define( 'CONTROLLERS_DIR', SITE_ROOT.'/Controllers' );
define( 'MODELS_DIR', SITE_ROOT.'/Models' );

// Server HTTP port (can omit if the default 80 is used)
define('HTTP_SERVER_PORT', '80');
/* Name of the virtual directory the site runs in, for example:
   '/tshirtshop/' if the site runs at http://www.example.com/tshirtshop/
   '/' if the site runs at http://www.example.com/ */

define( 'VIRTUAL_LOCATION', '/');

//These should be true while developing the web site
define( 'IS_WARNING_FATAL', true );
define( 'DEBUGGING', true );

//the error types to be reported
define( 'ERROR_TYPES', E_ALL );

//setting about mailing the error message to admin
define( 'SEND_ERROR_MAIL', false );
define( 'ADMIN_ERROR_MAIL', 'darsal09@yahoo.com' );
define( 'SENDMAIL_FROM', 'inter09@terra.com' );

ini_set( 'sendmail_from', SENDMAIL_FROM );

//By default we don't log errors to file
define( 'LOG_ERRORS', true );
define( 'LOG_ERRORS_FILE', SITE_ROOT.'\erros_log.txt' );
define( 'SITE_GENERIC_ERROR_MESSAGE', '<h1>Reorg Testing Errors!</h1>' );

define( 'DB_PERSISTENCY', true );
define( 'DB_SERVER', 'localhost' );
define( 'DB_USERNAME', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_DATABASE', 'reorg' );
define( 'PDO_DSN', 'mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE );


try{
    $pdo = new PDO('mysql:host='.DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->query('CREATE DATABASE IF NOT EXISTS '.DB_DATABASE);

    $pdo->query('use '.DB_DATABASE);


    $pdo->query( "CREATE TABLE IF NOT EXISTS `doctor_lunch_money` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `physician_first_name` varchar(30) NOT NULL,
  `applicable_manufacturer_or_applicable_gpo_making_payment_state` varchar(2) NOT NULL,
  `physician_last_name` varchar(50) NOT NULL,
  `date_of_payment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `recipient_country` varchar(30) NOT NULL,
  `form_of_payment_or_transfer_of_value` varchar(50) NOT NULL,
  `recipient_state` varchar(2) NOT NULL,
  `nature_of_payment_or_transfer_of_value` varchar(50) NOT NULL,
  `recipient_primary_business_street_address_line1` varchar(100) NOT NULL,
  `physician_license_state_code1` varchar(2) NOT NULL,
  `recipient_primary_business_street_address_line2` varchar(20) NOT NULL,
  `covered_recipient_type` varchar(100) NOT NULL,
  `name_of_associated_covered_device_or_medical_supply1` varchar(30) NOT NULL,
  `name_of_associated_covered_device_or_medical_supply2` varchar(250) NOT NULL,
  `name_of_associated_covered_device_or_medical_supply3` varchar(250) NOT NULL,
  `name_of_associated_covered_device_or_medical_supply4` varchar(250) NOT NULL,
  `name_of_associated_covered_device_or_medical_supply5` varchar(250) NOT NULL,
  `delay_in_publication_indicator` varchar(5) NOT NULL,
  `recipient_zip_code` varchar(10) NOT NULL,
  `applicable_manufacturer_or_applicable_gpo_making_payment_name` varchar(150) NOT NULL,
  `product_indicator` varchar(20) NOT NULL,
  `record_id` int(11) NOT NULL,
  `dispute_status_for_publication` varchar(5) NOT NULL,
  `recipient_city` varchar(50) NOT NULL,
  `third_party_payment_recipient_indicator` varchar(50) NOT NULL,
  `physician_specialty` varchar(250) NOT NULL,
  `physician_primary_type` varchar(50) NOT NULL,
  `charity_indicator` varchar(5) NOT NULL,
  `applicable_manufacturer_or_applicable_gpo_making_payment_id` int(11) NOT NULL,
  `physician_profile_id` int(11) NOT NULL,
  `payment_publication_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `submitting_applicable_manufacturer_or_applicable_gpo_name` varchar(150) NOT NULL,
  `program_year` year(4) NOT NULL,
  `number_of_payments_included_in_total_amount` int(11) NOT NULL,
  `physician_ownership_indicator` varchar(5) NOT NULL,
  `applicable_manufacturer_or_applicable_gpo_making_payment_country` varchar(30) NOT NULL,
  `total_amount_of_payment_usdollars` decimal(18,2) NOT NULL,
  `physician_middle_name` varchar(30) NOT NULL,
  `contextual_information` text NOT NULL,
  `teaching_hospital_id` int(11) NOT NULL,
  `teaching_hospital_name` varchar(250) NOT NULL,
  `physician_name_suffix` varchar(10) NOT NULL,
  `recipient_province` varchar(30) NOT NULL,
  `recipient_postal_code` varchar(11) NOT NULL,
  `physician_license_state_code2` varchar(2) NOT NULL,
  `physician_license_state_code3` varchar(2) NOT NULL,
  `physician_license_state_code4` varchar(2) NOT NULL,
  `physician_license_state_code5` varchar(2) NOT NULL,
  `city_of_travel` varchar(50) NOT NULL,
  `state_of_travel` varchar(30) NOT NULL,
  `country_of_travel` varchar(50) NOT NULL,
  `name_of_third_party_entity_receiving_payment_or_transfer_of_valu` varchar(250) NOT NULL,
  `third_party_equals_covered_recipient_indicator` varchar(30) NOT NULL,
  `name_of_associated_covered_drug_or_biological1` varchar(100) NOT NULL,
  `name_of_associated_covered_drug_or_biological2` varchar(100) NOT NULL,
  `name_of_associated_covered_drug_or_biological3` varchar(100) NOT NULL,
  `name_of_associated_covered_drug_or_biological4` varchar(100) NOT NULL,
  `name_of_associated_covered_drug_or_biological5` varchar(100) NOT NULL,
  `ndc_of_associated_covered_drug_or_biological1` varchar(30) NOT NULL,
  `ndc_of_associated_covered_drug_or_biological2` varchar(30) NOT NULL,
  `ndc_of_associated_covered_drug_or_biological3` varchar(30) NOT NULL,
  `ndc_of_associated_covered_drug_or_biological4` varchar(30) NOT NULL,
  `ndc_of_associated_covered_drug_or_biological5` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `physician_first_name` (`physician_first_name`,`physician_middle_name`,`physician_last_name`,`physician_license_state_code1`,`physician_license_state_code2`,`physician_license_state_code3`,`physician_license_state_code4`,`physician_license_state_code5`,`physician_specialty`,`physician_primary_type`,`physician_ownership_indicator`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='holds the information about the doctor''s lunch money'" );
}catch( Exception $e ){
    echo $e->getMessage().PHP_EOL;
}


shell_exec("crontab -l | { cat; echo '*/1    *    *    *    *    command2'; } |crontab -");