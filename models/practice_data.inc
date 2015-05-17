<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class PracticeData
{
  public $id = null;
  public $user_id = null;
  public $instructor_id = null;
  public $practice_id = null;
  public $aircraft_id = null;
  public $date = null;
  public $count = null;
  public $time = null;
  public $comments = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (isset($data['id'])) $this->id = $data['id'];
    if (isset($data['user_id'])) $this->user_id = $data['user_id'];
    if (isset($data['instructor_id'])) $this->instructor_id = $data['instructor_id'];
    if (isset($data['practice_id'])) $this->practice_id = $data['practice_id'];
    if (isset($data['aircraft_id'])) $this->aircraft_id = $data['aircraft_id'];
    if (isset($data['date'])) $this->date = $data['date'];
    if (isset($data['count'])) $this->count = $data['count'];
    if (isset($data['time'])) $this->time = $data['time'];
    if (isset($data['comments'])) $this->comments = $data['comments'];
  }

  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */
  public function storeFormValues ( $params ) {
    // Store all the parameters
    $this->__construct( $params );
  }

  /**
  * Returns an PracticeData object matching the given article ID
  *
  * @param int The article ID
  * @return PracticeData|false The article object, or false if the record was not found or there was a problem
  */
  public static function getById($id) {
    $st = DB::query("SELECT * FROM practice_data WHERE id = :id", array(":id" => $id));
    if ($row = $st->fetch())
        return new PracticeData( $row );
    return NULL;
  }

  /**
  * Returns all (or a range of) PracticeData objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of PracticeData objects; totalRows => Total number of articles
  */
  public static function getList($user_id = NULL, $numRows=1000000, $order = 'date', $where = NULL) {
    if (!empty($user_id))
      $where = "`user_id`=$user_id" . (empty($where) ? NULL : " AND $where");

    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS * FROM practice_data" .
          (!empty($where) ? " WHERE $where" : NULL) .
          (!empty($numRows) ? " LIMIT $numRows" : NULL) .
          (!empty($order) ? (' ORDER BY ' . ltrim($order, '-+') . ($order[0] == '-' ? ' DESC' : ' ASC')) : NULL));

    $list = array();
    while ($row = $st->fetch()) {
      $list[] = new PracticeData($row);
    }

    // Now get the total number of articles that matched the criteria
    $totalRows = DB::fetch("SELECT FOUND_ROWS() AS totalRows");

    return array ( "results" => $list, "totalRows" => $totalRows['totalRows'] );
  }

  public static function getStatistic($user_id = NULL) {
    $user_id = is_numeric($user_id) ? (int)$user_id : 0;
    $st = DB::query("SELECT `practice_id`, SUM(`count`) count, SUM(`time`) time FROM `practice_data` WHERE `user_id`=$user_id GROUP BY `practice_id`");

    $list = array();
    while ($row = $st->fetch()) {
      $list[$row['practice_id']] = array('practice_id' => $row['practice_id'], 'count' => $row['count'], 'time' => $row['time']);
    }
    return $list;
  }

  /**
  * Inserts the current PracticeData object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the PracticeData object already have an ID?
    if (!is_null($this->id)) trigger_error ( "PracticeData::insert(): Attempt to insert an PracticeData object that does have its id property set (to $this->id).", E_USER_ERROR );

    // Insert the PracticeData
    $this->id = DB::insert("INSERT INTO practice_data (
 `user_id`, `instructor_id`, `practice_id`, `aircraft_id`, `date`, `count`, `time`, `comments`)
    VALUES (
 :user_id, :instructor_id, :practice_id, :aircraft_id, :date, :count, :time, :comments)", array(
        ":user_id" => (int)$this->user_id,
        ":instructor_id" => (int)$this->instructor_id,
        ":practice_id" => (int)$this->practice_id,
        ":aircraft_id" => (int)$this->aircraft_id,
        ":date" => $this->date,
        ":count" => (int)$this->count,
        ":time" => $this->time,
        ":comments" => $this->comments,
    ));

    return !empty($this->id);
  }

  /**
  * Updates the current PracticeData object in the database.
  */
  public function update() {
    // Does the PracticeData object have an ID?
    if (is_null($this->id)) trigger_error ( "PracticeData::update(): Attempt to update an PracticeData object that does not have its id property set.", E_USER_ERROR );

    // Update the PracticeData
    $st = DB::query("UPDATE practice_data SET `user_id`=:user_id, `instructor_id`=:instructor_id, `practice_id`=:practice_id, `aircraft_id`=:aircraft_id, `date`=:date, `count`=:count, `time`=:time, `comments`=:comments WHERE id = :id", array(
        ":user_id" => (int)$this->user_id,
        ":instructor_id" => (int)$this->instructor_id,
        ":practice_id" => (int)$this->practice_id,
        ":aircraft_id" => (int)$this->aircraft_id,
        ":date" => $this->date,
        ":count" => (int)$this->count,
        ":time" => $this->time,
        ":comments" => $this->comments,
        ":id" => (int)$this->id,
      ));

    return TRUE;//$st->rowCount();
  }

  /**
  * Deletes the current PracticeData object from the database.
  */
  public function delete() {
    // Does the PracticeData object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "PracticeData::delete(): Attempt to delete an PracticeData object that does not have its id property set.", E_USER_ERROR );

    // Delete the PracticeData
    DB::query( "DELETE FROM practice_data WHERE id = :id LIMIT 1", array(":id" => $this->id));
  }
}
