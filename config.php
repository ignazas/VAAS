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

// removed db settings.

require( CLASS_PATH . "/news.php" );
require( CLASS_PATH . "/bookings.php" );


function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  error_log( $exception->getMessage() );
}
 
set_exception_handler( 'handleException' );
?>