<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class CalendarEvent
{
  public $event_id;
  public $event_title;
  public $event_day;
  public $event_time;
  public $event_desc;
  public $event_type;
  public $event_date;
  public $user_id;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (isset($data['event_id'])) $this->event_id = $data['event_id'];
    if (isset($data['event_title'])) $this->event_title = $data['event_title'];
    if (isset($data['event_year'])) $this->event_year = $data['event_year'];
    if (isset($data['event_month'])) $this->event_month = $data['event_month'];
    if (isset($data['event_day'])) $this->event_day = $data['event_day'];
    if (isset($data['event_time'])) $this->event_time = $data['event_time'];
    if (isset($data['event_desc'])) $this->event_desc = $data['event_desc'];
    if (isset($data['event_date'])) $this->event_date = $data['event_date'];
    if (isset($data['user_id'])) $this->user_id = $data['user_id'];

    if (isset($this->event_title) && in_array($this->event_title, array("šventė", "talka", "kita", "svečiai")))
	$this->event_type = $this->event_title;
    else
	$this->event_type = 'registracija';
  }

  /**
  * Returns an Calendar object matching the given date
  *
  * @param int The article ID
  * @return Calendar|false The article object, or false if the record was not found or there was a problem
  */
  public static function getByDate($date) {
    require_once dirname(__FILE__) . '/user.inc';

    if (is_string($date))
      $date = strtotime($date);

    $st = DB::query("SELECT * FROM `calendar_events` e INNER JOIN `jos_users` u ON u.id=e.user_id LEFT JOIN `jos_contxtd_details` ud ON u.id = ud.user_id WHERE e.event_month=:month AND e.event_year=:year AND e.event_day=:day ORDER BY e.event_time", array(':year' => date('Y', $date), ':month' => date('m', $date), ':day' => date('d', $date)));

    $list = array();
    while ($row = $st->fetch()) {
      $e = new CalendarEvent($row);
      $e->user = new User($row);
      $list[] = $e;
    }

    // Now get the total number of articles that matched the criteria
    $st = DB::query("SELECT FOUND_ROWS() AS totalRows");
    $totalRows = $st->fetch();

    return array ( "results" => $list, "totalRows" => $totalRows[0] );
  }

  /**
  * Returns an Calendar object matching the given user ID with date
  *
  * @param int The article ID
  * @return Calendar|false The article object, or false if the record was not found or there was a problem
  */
  public static function getByUser($userId, $date = NULL) {
    require_once dirname(__FILE__) . '/calendar_day.inc';

    if (is_object($userId))
      $userId = $userId->id;
    elseif (is_array($userId))
      $userId = $userId['id'];

    if (is_string($date))
      $date = strtotime($date);

    $params = array(':userId' => $userId);
    $filters = array('e.user_id=:userId');
    if (!empty($date)) {
      $filters[] = 'e.`event_date`=:date';
      $params[':date'] = $date;
    }

    $st = DB::query("SELECT * FROM `calendar_events` e INNER JOIN `jos_users` u ON u.id=e.user_id LEFT OUTER JOIN `days` d ON e.`event_date`=d.`day` WHERE " . implode(' AND ', $filters) . " ORDER by e.`event_date`", $params);

    $list = array();
    while ($row = $st->fetch()) {
      if (!isset($list[$row['event_id']]))
        $list[$row['event_id']] = $e = new CalendarEvent($row);
      else
        $e = $list[$row->event_id];
      $e->day = new CalendarDay($row);
    }

    // Now get the total number of articles that matched the criteria
    $st = DB::query("SELECT FOUND_ROWS() AS totalRows");
    $totalRows = $st->fetch();

    return array ( "results" => $list, "totalRows" => $totalRows[0] );
  }

  /**
  * Returns an Calendar object matching the given ID
  *
  * @param int The article ID
  * @return Calendar|false The article object, or false if the record was not found or there was a problem
  */
  public static function get($id) {
    require_once dirname(__FILE__) . '/user.inc';

    $st = DB::query("SELECT * FROM `calendar_events` e INNER JOIN `jos_users` u ON u.id=e.user_id LEFT JOIN `jos_contxtd_details` ud ON u.id = ud.user_id WHERE event_id=:id LIMIT 1", array(':id' => $id));

    if ($row = $st->fetch()) {
      $e = new CalendarEvent($row);
      $e->user = new User($row);
      return $e;
    }

    return NULL;
  }
}
