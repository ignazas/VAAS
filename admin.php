<?php
require_once dirname(__FILE__) . '/helpers/user.inc';
UserHelper::check_access();

require_once dirname(__FILE__) . "/config.php";
require_once dirname(__FILE__) . '/helpers/db.inc';
require_once dirname(__FILE__) . "/functions.php";

$action = isset( $_GET['action'] ) ? str_replace('admin/', '', $_GET['action']) : "";
$view = isset($_GET['view']) ? $_GET['view'] : 'Index';
if (function_exists($action))
  $action();
else {
  switch ( $action ) {
    case 'deleteBooking': delete_booking($_GET['bookingId']); break;
    default:
      if (($controller = load_controller($action)) && method_exists($controller, $view))
        $controller->{$view}();
      else {
        $controller = load_controller('Article');
        $controller->AdminItemList();
      }
      break;
  }
}

function bookings() {
    $st = DB::query("SELECT * FROM calendar_events LEFT JOIN days ON calendar_events.event_date=days.day ORDER by calendar_events.event_date DESC");
    $BookingList = array();

    while ( $row = $st->fetch() ) {
		$BookingList['bookings'][$row['event_id']]['event_id'] = $row['event_id'];
		$BookingList['bookings'][$row['event_id']]['event_time'] = $row['event_time'];
		$BookingList['bookings'][$row['event_id']]['event_desc'] = $row['event_desc'];
		$BookingList['bookings'][$row['event_id']]['event_date'] = $row['event_date'];
		$BookingList['bookings'][$row['event_id']]['event_title'] = $row['event_title'];
		$BookingList['bookings'][$row['event_id']]['status'] = $row['status'];
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

	require( TEMPLATE_PATH . "/admin/bookings.php" );
}

function delete_booking($booking_id) {

    // Does the Booking object have an ID?
    if ( is_null( $booking_id ) ) trigger_error ( "Attempt to delete an Booking object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Booking
    $st = DB::query("DELETE FROM calendar_events WHERE event_id = :event_id LIMIT 1", array(":event_id" => $booking_id));
	log_event("Admin", "BookingDeleted", $booking_id);
    header( "Location: admin.php?action=admin/bookings&status=eventDeleted" );
  }

function deleteDay() {
  $day = $_GET['day'];

    // Does the Day object have an ID?
    if ( is_null( $day ) ) trigger_error ( "Attempt to delete a Day that does not have its ID property set.", E_USER_ERROR );

    // Delete the Day setting
    $st = DB::query("DELETE FROM days WHERE day = :day LIMIT 1", array(":day" => $day));
    log_event("Admin", "DayDeleted", $day);

    $exploded_date = explode("-", $day);
	if (substr($exploded_date[1],0,1)=="0") {$exploded_date[1] = substr($exploded_date[1],1);};
	$exploded_date[1] += 1;

    header( "Location: admin.php?action=admin/working_days&status=dayDeleted&month=" . $exploded_date[1] . "&year=" . $exploded_date[0] );
}

function addDay() {
  $day = $_GET['day'];
  $status = $_GET['status'];
  $reason = isset($_GET['reason']) ? trim($_GET['reason']) : '';
  $confirmed = $_SESSION['user']['name'];
  $send_mail = isset($_GET['mail']) ? $_GET['mail'] : NULL;

  // Add day status
  $st = DB::query("DELETE FROM days WHERE day = :day", array(':day' => $day)); //delete old event for that day
  if($status=='delete') {
    log_event("Admin", "DayDeleted", $day);
  }
  else {
    $st = DB::query("INSERT INTO days (day, status, reason, confirmed) VALUES (:day, :status, :reason, :confirmed) on duplicate key UPDATE status=values(status), reason=values(reason), confirmed=values(confirmed)", array(
            ':day' => $day,
            ':status' => $status,
            ':reason' => $reason,
            ':confirmed' => $confirmed
          ));
    log_event("Admin", "DayAdded", $day);
  }

  //notification
  $receivers = array();
  switch($send_mail) {
    case 'all':
      require_once dirname(__FILE__) . '/models/user.inc';
      $data = User::getList();
      foreach ($data['results'] as $user) {
        $receivers[] = !empty($user->email_to) ? $user->email_to : $user->email;
      }
      break;
    case 'flying':
      require_once dirname(__FILE__) . '/models/calendar_event.inc';
      $data = CalendarEvent::getByDate($day);
      foreach ($data['results'] as $event) {
        if (!empty($event->user))
          $receivers[] = !empty($event->user->email_to) ? $event->user->email_to : $event->user->email;
      }
      break;
    case 'me':
      require_once dirname(__FILE__) . '/helpers/user.inc';
      $uid = UserHelper::get_id();
      if (!empty($uid)) {
        require_once dirname(__FILE__) . '/models/user.inc';
        $user = User::Get($uid);
        $receivers[] = !empty($user->email_to) ? $user->email_to : $user->email;
      }
      break;
  }
  send_mail($receivers, "Dienos statusas: " . $day, "Dienos statusas, kuriai Jūs buvote užsiregistravę skrydžiams, pasikeitė<br />Dabartinis statusas: " . $status . "<br />Pastaba: " . $reason . "<br />");

	$exploded_date = explode("-", $day);
	if(substr($exploded_date[1],0,1)=="0") {$exploded_date[1] = substr($exploded_date[1],1);};
	$exploded_date[1] += 1;
	$destination = !empty($_GET['destination']) ? $_GET['destination'] : ("index.php?action=calendar&month=" . $exploded_date[1] . "&year=" . $exploded_date[0]);
  if (headers_sent() === false)
    header("Location: $destination", true, 302);
  else
    echo '<meta http-equiv="Location" content="'.$destination.'"><script>window.location="'.$destination.'";</script>';
  echo 'test';
  die();
}

function working_days() {
    $st = DB::query("SELECT * FROM days ORDER by day DESC");
    $workingDays = array();

    while ( $row = $st->fetch() ) {
    	$workingDays['days'][$row['day']]['day'] = $row['day'];
		$workingDays['days'][$row['day']]['status'] = $row['status'];
		$workingDays['days'][$row['day']]['confirmed'] = $row['confirmed'];
		$workingDays['days'][$row['day']]['reason'] = $row['reason'];
    }
	if ( isset( $_GET['error'] ) ) {
	if ( $_GET['error'] == "dayNotFound" ) $workingDays['errorMessage'] = "Diena nerasta.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $workingDays['statusMessage'] = "Pakeitimai išsaugoti.";
    if ( $_GET['status'] == "dayDeleted" ) $workingDays['statusMessage'] = "Dienos žyma pašalinta.";
	if ( $_GET['status'] == "dayAdded" ) $workingDays['statusMessage'] = "Dienos žyma pridėta.";
  }

	require( TEMPLATE_PATH . "/admin/working_days.php" );
}
