<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class CalendarDay
{
  public $day;
  public $status;
  public $reason;
  public $confirmed;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (isset($data['day'])) $this->day = $data['day'];
    if (isset($data['status'])) $this->status = $data['status'];
    if (isset($data['reason'])) $this->reason = $data['reason'];
    if (isset($data['confirmed'])) $this->confirmed = $data['confirmed'];
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

    $st = DB::query("SELECT * FROM `days` WHERE `day`=:date", array(':date' => date('Y-m-d', $date)));

    $list = array();
    while ($row = $st->fetch()) {
      $list[] = new CalendarDay($row);
    }

    // Now get the total number of articles that matched the criteria
    $st = DB::query("SELECT FOUND_ROWS() AS totalRows");
    $totalRows = $st->fetch();

    return array ( "results" => $list, "totalRows" => $totalRows[0] );
  }
}
