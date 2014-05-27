<?php 

require_once dirname(__FILE__) . '/helpers/db.inc';
require_once dirname(__FILE__) . "/classes/news.php";
require_once dirname(__FILE__) . "/config.php";
require_once dirname(__FILE__) . "/common.php";
require_once dirname(__FILE__) . "/secure.php";
require_once dirname(__FILE__) . "/functions.php";

$action = isset( $_GET['action'] ) ? $_GET['action'] : ""; 
 
switch ( $action ) {
	case 'newArticle':
		newArticle();
    	break;
	case 'editArticle':
    	editArticle();
    	break;
	case 'deleteArticle':
	    deleteArticle();
	    break;
	case 'admin/news':
		listArticles();
	    break;
	case 'admin/bookings':
		bookings();
	    break;
	case 'admin/finance':
		finance();
	    break;
	case 'admin/working_days':
		working_days();
	    break;
	case 'deleteEvent':
		deleteEvent();
	    break;
	case 'deleteDay':
		deleteDay($_GET['day']);
	    break;
	case 'addDay':
		addDay($_GET['day'], $_GET['status'], $_GET['reason']);
	    break;
	case 'deleteBooking':
    	delete_booking($_GET['bookingId']);
    	break;
  	default:
    	listArticles();
}
  
function newArticle() {

  $results = array();
  $results['pageTitle'] = "New Article";
  $results['formAction'] = "newArticle";
 
  if ( isset( $_POST['saveChanges'] ) ) {
 
    // User has posted the article edit form: save the new article
    $article = new Article;
    $article->storeFormValues( $_POST );
    $article->insert();
	log_event("Admin", "ArticleCreated", "");
    header( "Location: admin.php?status=changesSaved" );
 
  } elseif ( isset( $_POST['cancel'] ) ) {
 
    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } else {
 
    // User has not posted the article edit form yet: display the form
    $results['article'] = new Article;
    require( TEMPLATE_PATH . "/admin/editArticle.php" );
  }
 
 
}
 
 
function editArticle() {

  $results = array();
  $results['pageTitle'] = "Edit Article";
  $results['formAction'] = "editArticle";
 
  if ( isset( $_POST['saveChanges'] ) ) {
 
    // User has posted the article edit form: save the article changes
 
    if ( !$article = Article::getById( (int)$_POST['articleId'] ) ) {
      header( "Location: admin.php?error=articleNotFound" );
      return;
    }
 
    $article->storeFormValues( $_POST );
    $article->update();
	
	//log it		
	log_event("Admin", "ArticleEdited", "");
	
    header( "Location: admin.php?status=changesSaved" );
 
  } elseif ( isset( $_POST['cancel'] ) ) {
 
    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } else {
 
    // User has not posted the article edit form yet: display the form
    $results['article'] = Article::getById( (int)$_GET['articleId'] );
    require( TEMPLATE_PATH . "/admin/editArticle.php" );
  }
 
}
 
 
function deleteArticle() {

  if ( !$article = Article::getById( (int)$_GET['articleId'] ) ) {
    header( "Location: admin.php?error=articleNotFound" );
    return;
  }
	
	log_event("Admin", "ArticleDeleted", "");
  
	$article->delete();
	header( "Location: admin.php?status=articleDeleted" );
}

function listArticles() {

  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "All Articles";
 
  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "articleNotFound" ) $results['errorMessage'] = "Pranešimas nerastas.";
	if ( $_GET['error'] == "eventNotFound" ) $results['errorMessage'] = "Registracija nerasta.";
  }
 
  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Pakeitimai išsaugoti.";
    if ( $_GET['status'] == "articleDeleted" ) $results['statusMessage'] = "Pranešimas pašalintas.";
  }
 
  require( TEMPLATE_PATH . "/admin/listArticles.php" );
}

function bookings() {
    $st = DB::query("SELECT * FROM calendar_events LEFT JOIN days ON calendar_events.event_date=days.day ORDER by calendar_events.event_date");
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

function finance(){
	
	require( TEMPLATE_PATH . "/admin/finance.php" );
}

function deleteDay($day) {
 
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

function addDay($day, $status, $reason) {
	$confirmed = $_SESSION['user']['name'];
    // Add day status
    $st = DB::query("INSERT INTO days (day, status, reason, confirmed) VALUES (:day, :status, :reason, :confirmed) on duplicate key UPDATE status=values(status), reason=values(reason), confirmed=values(confirmed)", array(
        ':day' => $day,
        ':status' => $status,
        ':reason' => $reason,
        ':confirmed' => $confirmed
    ));
    if($status=='delete') {$st = DB::query("DELETE FROM days WHERE day = :day", array(':day' => $day));};
    $st = DB::query("SELECT user_id, email FROM calendar_events LEFT JOIN jos_users ON user_id = id WHERE event_date = :day", array(':day' => $day));
	$RelatedEmails = array();
	while ( $row = $st->fetch() ) {
		$RelatedEmails = $row['email'];
    }
	send_mail($RelatedEmails,"Dienos statusas: " . $day, "Dienos statusas, kuriai Jūs buvote užsiregistravę skrydžiams, pasikeitė<br />
	Dabartinis statusas: " . $status . "<br />" .
	"Pastaba: " . $reason . "<br />"
	);
    log_event("Admin", "DayAdded", $day);
	
	$exploded_date = explode("-", $day);
	if(substr($exploded_date[1],0,1)=="0") {$exploded_date[1] = substr($exploded_date[1],1);};
	$exploded_date[1] += 1;
    header( "Location: index.php?action=calendar&status=dayAdded&month=" . $exploded_date[1] . "&year=" . $exploded_date[0] );
}
function working_days() {
    $st = DB::query("SELECT * FROM days ORDER by day");
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

?>