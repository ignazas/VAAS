<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Calendar
{
  public $event_id;
  public $event_title;
  public $event_day;
  public $event_time;
  public $event_desc;

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
  }

  /**
  * Returns an Calendar object matching the given article ID
  *
  * @param int The article ID
  * @return Calendar|false The article object, or false if the record was not found or there was a problem
  */
  public static function getByDate($date) {
    if (is_string($date))
      $date = strtotime($date);

    $st = DB::query("SELECT e.* FROM `calendar_events` e INNER JOIN `jos_users` u ON u.id=e.user_id WHERE e.event_month=:month AND e.event_year=:year AND e.event_day=:day ORDER BY e.event_time", array(':year' => date('Y', $date), ':month' => date('m', $date), ':day' => date('d', $date)));

    $list = array();
    while ($row = $st->fetch()) {
      $list[] = new Calendar($row);
    }

    // Now get the total number of articles that matched the criteria
    $st = DB::query("SELECT FOUND_ROWS() AS totalRows");
    $totalRows = $st->fetch();

    return array ( "results" => $list, "totalRows" => $totalRows[0] );
  }
}
