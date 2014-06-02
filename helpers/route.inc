<?php


class Index {
    /* INDEX.PHP */
    public static function ajax() {
        if (isset($_GET['method']))
            include dirname(__FILE__) . '/../ajax/' . $_GET['method'] . '.inc';
        exit;
    }

    public static function news() {
        require_once dirname(__FILE__) . '/../classes/news.php';
        $data = Article::getList();
        $results = array('articles' => $data['results'], 'totalRows' => $data['totalRows']);
        require( TEMPLATE_PATH . "/news.php" );
    }

    public static function singleNews() {
        if ( isset($_GET["articleId"])) {
            require_once dirname(__FILE__) . '/../classes/news.php';
            $results = array('article' => Article::getById((int)$_GET["articleId"]));
        }

        require( TEMPLATE_PATH . "/singleNews.php" );
    }

    public static function finance() {
      require( TEMPLATE_PATH . "/finance.php" );
    }

    public static function calendar() {
      require( TEMPLATE_PATH . "/calendar.php" );
    }

    public static function booking() {
      require( TEMPLATE_PATH . "/booking.php" );
    }

    public static function my_bookings() {
        $st = DB::query("SELECT * FROM calendar_events LEFT JOIN days ON calendar_events.event_date=days.day ORDER by calendar_events.event_date");

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

    public static function deleteBooking() {
        if (!empty($_GET['bookingId'])) {
            $booking_id = $_GET['bookingId'];
             // Does the Booking object have an ID?
            if ( is_null( $booking_id ) ) trigger_error ( "Attempt to delete an Booking object that does not have its ID property set.", E_USER_ERROR );

            // Delete the Booking
            $st = DB::query( "DELETE FROM calendar_events WHERE event_id = :event_id LIMIT 1", array(":event_id" => $booking_id));

            log_event('N/A','BookingRemove',$booking_id);
            header( "Location: index.php?action=my_bookings&status=eventDeleted" );
        }
    }

    public static function contact() {
        require( TEMPLATE_PATH . "/contact.php" );
    }

    public static function off() {
        require( TEMPLATE_PATH . "/off.php" );
    }

    public static function on() {
        require( TEMPLATE_PATH . "/on.php" );
    }

    public static function svecias() {
        require( TEMPLATE_PATH . "/svecias.php" );
    }

    public static function logbook() {
          require( TEMPLATE_PATH . "/logbook.php" );
    }
}
