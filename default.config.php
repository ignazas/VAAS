<?php
ini_set( "display_errors", true );
error_reporting(E_ALL & ~E_DEPRECATED);

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
define('DB_USERNAME', '???');
define('DB_PASSWORD', '???');

function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  error_log( $exception->getMessage() );
}
 
set_exception_handler( 'handleException' );

require_once dirname(__FILE__) . '/helpers/strptime.inc';
require_once dirname(__FILE__) . '/helpers/get_magic_quotes_gpc.inc';
