<?php
echo '<script
			  src="https://code.jquery.com/jquery-2.2.4.min.js"
			  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
			  crossorigin="anonymous"></script>';
require_once 'includes/configs.php';


?>
<script>
    var scrape = {
        init:function(){
            this.getData();
        },
        getData:function(){
            $.post( '/Controllers/',
                {

                },
                function( data ){
                    console.log( data );
                },
            'json')
        }
    };


    $( function(){
       scrape.init();
    });
</script>
<?php
function  my_autoload( $class )
{
    require_once MODELS_DIR.'/'.$class.'.php';
}

spl_autoload_register( 'my_autoload' );

//$file = file_get_contents( 'https://openpaymentsdata.cms.gov/views/INLINE/rows.json?accessType=WEBSITE&method=getByIds&asHashes=true&start=0&length=50&meta=true&%24order=%3Aid' );

//print_r( $file );

//exit;

/*// Initialize options for REST interface
$adb_url="http://127.0.0.1:8529";
$adb_option_defaults = array(
    CURLOPT_HEADER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 2
);

// ArangoDB REST function.
// Connection are created demand and closed by PHP on exit.
function adb_rest($method,$uri,$querry=NULL,$json=NULL,$options=NULL){
    global $adb_url,$adb_handle,$adb_option_defaults;

    // Connect
    if(!isset($adb_handle)) $adb_handle = curl_init();

    echo "DB operation: $method $uri $querry $json\n";

    // Compose querry
    $options = array(
        CURLOPT_URL => $adb_url.$uri."?".$querry,
        CURLOPT_CUSTOMREQUEST => $method, // GET POST PUT PATCH DELETE HEAD OPTIONS
        CURLOPT_POSTFIELDS => $json,
    );
    curl_setopt_array($adb_handle,($options + $adb_option_defaults));

    // send request and wait for responce
    $responce =  json_decode(curl_exec($adb_handle),true);

    echo "Responce from DB: \n";
    print_r($responce);

    return($responce);
}
*/



$url = 'https://openpaymentsdata.cms.gov/resource/mw4g-bs44.json';
//$ch = curl_init('https://openpaymentsdata.cms.gov/resource/mw4g-bs44.json');

//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt_array($ch, [
                    CURLOPT_SSL_VERIFYPEER => false,
                    // Will return the response, if false it print the response
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_URL => $url,
                    CURLOPT_FAILONERROR => true
                ]);

// Execute
if( !( $result=curl_exec($ch) ) ){
    die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
}
// Closing
curl_close($ch);

$data = json_decode($result, true);

var_dump($data );
$lmTable = new lunchMoneyTable();

foreach( $data AS $row ){
    $lmTable->add( $row );
}