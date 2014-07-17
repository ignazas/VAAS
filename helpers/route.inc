<?php

require_once dirname(__FILE__) . '/messages.inc';

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
      require_once dirname(__FILE__) . '/../models/calendar_event.inc';

      $BookingList = CalendarEvent::getByUser($_SESSION['user']['id']);

      require( TEMPLATE_PATH . "/my_bookings.php" );
    }

    public static function deleteBooking() {
      if (!empty($_GET['bookingId'])) {
        $destination = !empty($_GET['destination']) ? $_GET['destination'] : 'index.php?action=my_bookings';

        $bookingIdList = array();
        foreach (explode(',', $_GET['bookingId']) as $booking_id)
          if (!empty($booking_id) && is_numeric($booking_id))
            $bookingIdList[] = (int)$booking_id;

        // Does the Booking object have an ID?
        if (empty($bookingIdList)) {
          //trigger_error ( "Attempt to delete an Booking object that does not have its ID property set.", E_USER_ERROR );
          Messages::set_message("Registracija nerasta.", 'errors');
        }
        else {
          // Delete the Booking
          $st = DB::query("DELETE FROM calendar_events WHERE event_id IN (" . implode(',', $bookingIdList) . ")");

          $deleted = $st->rowCount();
          if (empty($deleted)) {
            Messages::set_message("Registracija nerasta.", 'errors');
          }
          else {
            foreach ($bookingIdList as $booking_id)
              log_event('N/A','BookingRemove',$booking_id);
            Messages::set_message("Registracija pašalinta.");
          }
        }
        header( "Location: $destination" );
      }
    }

    public static function contact() {
        require( TEMPLATE_PATH . "/contact.php" );
    }

    public static function off() {
	require_once dirname(__FILE__) . '/user.inc';
	UserHelper::log_out();
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
