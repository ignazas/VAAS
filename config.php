<?php
ini_set( "display_errors", true );
if(function_exists('date_default_timezone_set'))
{
   date_default_timezone_set("Europe/Vilnius");
}
else
{
   putenv("TZ=Europe/Vilnius");
}

define( "CATALOG", "vaas" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
define( "HOMEPAGE_NUM_ARTICLES", 5 );


// DB del mysql query
define('DB_DSN', 'mysql:host=localhost;dbname=zadmin_vanza2;charset=utf8' );
define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'vanza2');
define('DB_PASSWORD', 'e9yje9uja');
define('DB_DATABASE', 'zadmin_vanza2');

function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  error_log( $exception->getMessage() );
}
 
set_exception_handler( 'handleException' );



?>