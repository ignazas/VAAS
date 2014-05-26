<?php

<<<<<<< HEAD
	require "config.php";
	require "functions.php";
    require "helpers/route.inc";
	
	$con=DB::connect();
    	
	$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

	
	switch ( $action ) {
  		case 'news':
    		news();
    		break;
		case 'singleNews':
    		singleNews();
    		break;
  		case 'finance':
    		finance();
    		break;
		case 'calendar':
    		calendar();
    		break;
		case 'my_bookings':
    		my_bookings();
    		break;
		case 'deleteBooking':
    		delete_booking($_GET['bookingId']);
    		break;
		case 'contact':
    		contact();
    		break;
		case 'user':
    		user();
    		break;
		case 'off':
    		off();
    		break;
		case 'on':
    		on();
    		break;
		case 'svecias':
    		svecias();
    		break;
		case 'logbook':
    		logbook();
    		break;
  		default:
    		home();
	}
	
	function news() {
		require( CLASS_PATH . "/news.php" );
	  $results = array();
	  $data = Article::getList();
	  $results['articles'] = $data['results'];
	  $results['totalRows'] = $data['totalRows'];
	  require( TEMPLATE_PATH . "/news.php" );
	}
 	
 	function singleNews() {
 		require( CLASS_PATH . "/news.php" );
		if ( isset($_GET["articleId"])) {
		  $results = array();
		  $results['article'] = Article::getById( (int)$_GET["articleId"] );
		}
		
		require( TEMPLATE_PATH . "/singleNews.php" );
	}
=======
require "config.php";
require "functions.php";
require "helpers/route.inc";
>>>>>>> 756168da0a436078d33620e4211339dc37b02db3

$con=DB::connect();

<<<<<<< HEAD
 	function calendar() {
	  require( TEMPLATE_PATH . "/calendar.php" );
	}

 	function booking() {
	  require( TEMPLATE_PATH . "/booking.php" );
}

	function my_bookings() {
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT * FROM calendar_events LEFT JOIN days ON calendar_events.event_date=days.day ORDER by calendar_events.event_date";
    $st = $conn->prepare( $sql );
    $st->execute();
	
    $BookingList = array();
    while ( $row = $st->fetch() ) {
		$BookingList['bookings'][$row['event_id']]['event_id'] = $row['event_id'];
		$BookingList['bookings'][$row['event_id']]['event_time'] = $row['event_time'];
		$BookingList['bookings'][$row['event_id']]['event_desc'] = $row['event_desc'];
		$BookingList['bookings'][$row['event_id']]['event_date'] = $row['event_date'];
		$BookingList['bookings'][$row['event_id']]['status'] = $row['status'];
		$BookingList['bookings'][$row['event_id']]['user_id'] = $row['user_id'];
    }
	
	if ( isset( $_GET['error'] ) ) {
	    if ( $_GET['error'] == "articleNotFound" ) $BookingList['errorMessage'] = "Pranešimas nerastas.";
		if ( $_GET['error'] == "eventNotFound" ) $BookingList['errorMessage'] = "Registracija nerasta.";
	  }
 
  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $BookingList['statusMessage'] = "Pakeitimai išsaugoti.";
    if ( $_GET['status'] == "articleDeleted" ) $BookingList['statusMessage'] = "Pranešimas pašalintas.";
    if ( $_GET['status'] == "eventDeleted" ) $BookingList['statusMessage'] = "Registracija pašalinta.";
  }
	
	require( TEMPLATE_PATH . "/my_bookings.php" );
}
	
	function delete_booking($booking_id) {
 
    // Does the Booking object have an ID?
    if ( is_null( $booking_id ) ) trigger_error ( "Attempt to delete an Booking object that does not have its ID property set.", E_USER_ERROR );
 
    // Delete the Booking
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM calendar_events WHERE event_id = :event_id LIMIT 1" );
    $st->bindValue( ":event_id", $booking_id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
    

	//log it
	mysql_query("INSERT INTO log(user, event, param) VALUES ('N/A','BookingRemove','". $booking_id ."')");
	log_event('User','BookingDeleted',$booking_id);
    header( "Location: index.php?action=my_bookings&status=eventDeleted" );
  }


 	function contact() {
	  require( TEMPLATE_PATH . "/contact.php" );
}
	function user() {
	  require( TEMPLATE_PATH . "/user.php" );
}
	function home() {
	  require( TEMPLATE_PATH . "/home.php" );
}
	function off() {
	  require( TEMPLATE_PATH . "/off.php" );
}
	function on() {
	  require( TEMPLATE_PATH . "/on.php" );
}
	function svecias() {
	  require( TEMPLATE_PATH . "/svecias.php" );
}
	function logbook() {
	  require( TEMPLATE_PATH . "/logbook.php" );
}
	

	

	if (method_exists('Index', $action))
        Index::$action();
    else if ($controller = load_controller($action))
        $controller->Run();
    else
		Index::home();

DB::close();



?>



    
=======
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
if (method_exists('Index', $action))
  Index::$action();
else if ($controller = load_controller($action))
  $controller->Run();
else
  Index::home();

DB::close();
>>>>>>> 756168da0a436078d33620e4211339dc37b02db3
