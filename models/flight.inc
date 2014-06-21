<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Flight
{

  public $id = null;
  public $date = null;
  public $pilot = null;
  public $passenger = null;
  public $callsign = null;
  public $task = null;
  public $amount = null;
  public $duration = null;
  private $old_callsign = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    //save old callsign
    if (isset($data['old_callsign'])) {
    	$this->old_callsign = $data['old_callsign'];
    } elseif (isset($data['callsign']) && isset($this->callsign) && ($this->callsign != $data['callsign'])) {
    	$this->old_callsign = $this->callsign;
	}
	if (isset($data['id'])) $this->id = $data['id'];
    if (isset($data['date'])) $this->date = $data['date'];
	if (isset($data['pilot'])) $this->pilot = $data['pilot'];
	if (isset($data['passenger'])) $this->passenger = $data['passenger'];
    if (isset($data['callsign'])) $this->callsign = $data['callsign'];
	if (isset($data['task'])) $this->task = $data['task'];
	if (isset($data['amount'])) $this->amount = $data['amount'];
	if (isset($data['duration'])) $this->duration = $data['duration'];
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
  * Returns an Flight object matching the given article ID
  *
  * @param int The article ID
  * @return Flight|false The article object, or false if the record was not found or there was a problem
  */
  public static function getByCallsign($callsign) {
    $st = DB::query("SELECT * FROM flights WHERE callsign = :callsign", array(":callsign" => $callsign));
    if ($row = $st->fetch())
        return new Flight( $row );
    return NULL;
  }

  public static function getById($id) {
    $st = DB::query("SELECT * FROM flights WHERE id = :id", array(":id" => $id));
    if ($row = $st->fetch())
        return new Flight( $row );
    return NULL;
  }

  /**
  * Returns all (or a range of) Flight objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of Flight objects; totalRows => Total number of articles
  */
  public static function getList( $numRows=1000000) {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS * FROM flights
            LIMIT $numRows");

    $list = array();
    while ($row = $st->fetch()) {
      $list[] = new Flight($row);
    }

    // Now get the total number of articles that matched the criteria
    $st = DB::query("SELECT FOUND_ROWS() AS totalRows");
    $totalRows = $st->fetch();

    return array ( "results" => $list, "totalRows" => $totalRows[0] );
  }

  /**
  * Inserts the current Flight object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the Flight object already have an ID?
    if ( is_null( $this->callsign ) ) trigger_error ( "Flight::insert(): Attempt to insert an Flight object that does not have its callsign property set (to $this->callsign).", E_USER_ERROR );

    // Insert the Flight
    $st = DB::query("INSERT INTO flights (date, callsign, pilot, passenger, task, amount, duration)
    VALUES (:date, :callsign, :pilot, :passenger, :task, :amount, :duration)", array(
        ":date" => $this->date,
        ":callsign" => $this->callsign,
        ":pilot" => $this->pilot,
        ":passenger" => $this->passenger,
        ":task" => $this->task,
        ":amount" => $this->amount,
        ":duration" => $this->duration,

    ));

    return $st->rowCount();
  }

  /**
  * Updates the current Flight object in the database.
  */
  public function update() {
    // Does the Flight object have an ID?
    if ( is_null( $this->callsign ) ) trigger_error ( "Flight::update(): Attempt to update an Flight object that does not have its callsign property set.", E_USER_ERROR );

    // Update the Flight
    $st = DB::query("UPDATE flights SET model=:model, callsign = :callsign WHERE callsign = :old_callsign", array(
        ":model" => $this->model,
        ":callsign" => $this->callsign,
        ":old_callsign" => isset($this->old_callsign) ? $this->old_callsign : $this->callsign,
      ));

    return $st->rowCount();
  }

  /**
  * Deletes the current Flight object from the database.
  */
  public function delete() {
    // Does the Flight object have an ID?
    if ( is_null( $this->callsign ) ) trigger_error ( "Flight::delete(): Attempt to delete an Flight object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Flight
    DB::query( "DELETE FROM flights WHERE callsign = :callsign LIMIT 1", array(":callsign" => $this->callsign));
  }
}
