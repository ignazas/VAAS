<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Flight
{

  public $record_id = null;
  public $date = null;
  public $instructor = null;
  public $payer = null;
  public $airplane_registration = null;
  public $task = null;
  public $amount = null;
  public $duration = null;
  public $service_id = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
	if (isset($data['record_id'])) $this->record_id = $data['record_id'];
    if (isset($data['date'])) $this->date = $data['date'];
	if (isset($data['instructor'])) $this->instructor['instructor'];
	if (isset($data['payer'])) $this->payer = $data['payer'];
    if (isset($data['airplane_registration'])) $this->airplane_registration = $data['airplane_registration'];
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
  public static function getById($id) {
    $st = DB::query("SELECT * FROM flights WHERE record_id = :id", array(":id" => $id));
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
    $totalRows = DB::fetch("SELECT FOUND_ROWS() AS totalRows");

    return array ( "results" => $list, "totalRows" => $totalRows['totalRows'] );
  }

  /**
  * Inserts the current Flight object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the Flight object already have an ID?
    if (!is_null($this->record_id)) trigger_error ( "Flight::insert(): Attempt to insert an Flight object that does have its record_id property set (to $this->record_id).", E_USER_ERROR );

    // Insert the Flight
    $st = DB::query("INSERT INTO flights (date, airplane_registration, instructor, payer, task, amount, duration)
    VALUES (:date, :airplane_registration, :instructor, :payer, :task, :amount, :duration)", array(
        ":date" => $this->date,
        ":airplane_registration" => $this->airplane_registration,
        ":instructor" => $this->instructor,
        ":payer" => $this->payer,
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
    if (is_null($this->record_id)) trigger_error ( "Flight::update(): Attempt to update an Flight object that does not have its record_id property set.", E_USER_ERROR );

    // Update the Flight
    $st = DB::query("UPDATE flights SET model=:model, airplane_registration = :airplane_registration WHERE record_id = :record_id", array(
        ":model" => $this->model,
        ":airplane_registration" => $this->airplane_registration,
        ":record_id" => $this->record_id,
      ));

    return $st->rowCount();
  }

  /**
  * Deletes the current Flight object from the database.
  */
  public function delete() {
    // Does the Flight object have an ID?
    if ( is_null( $this->record_id ) ) trigger_error ( "Flight::delete(): Attempt to delete an Flight object that does not have its record_id property set.", E_USER_ERROR );

    // Delete the Flight
    DB::query( "DELETE FROM flights WHERE record_id = :record_id LIMIT 1", array(":record_id" => $this->record_id));
  }
}
