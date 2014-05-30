<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Aircraft
{

  public $model = null;
  public $callsign = null;
  private $old_callsign = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    //save old callsign
    if (isset($data['old_callsign'])) $this->old_callsign = $data['old_callsign'];
    elseif (isset($data['callsign']) && isset($this->callsign) && ($this->callsign != $data['callsign'])) $this->old_callsign = $this->callsign;

    if (isset($data['model'])) $this->model = $data['model'];
    if (isset($data['callsign'])) $this->callsign = $data['callsign'];
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
  * Returns an Aircraft object matching the given article ID
  *
  * @param int The article ID
  * @return Aircraft|false The article object, or false if the record was not found or there was a problem
  */
  public static function getByCallsign($callsign) {
    $st = DB::query("SELECT * FROM aircrafts WHERE callsign = :callsign", array(":callsign" => $callsign));
    if ($row = $st->fetch())
        return new Aircraft( $row );
    return NULL;
  }

  /**
  * Returns all (or a range of) Aircraft objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of Aircraft objects; totalRows => Total number of articles
  */
  public static function getList( $numRows=1000000, $order="callsign" ) {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS * FROM aircrafts
            ORDER BY $order LIMIT $numRows");

    $list = array();
    while ($row = $st->fetch()) {
      $list[] = new Aircraft($row);
    }

    // Now get the total number of articles that matched the criteria
    $st = DB::query("SELECT FOUND_ROWS() AS totalRows");
    $totalRows = $st->fetch();

    return array ( "results" => $list, "totalRows" => $totalRows[0] );
  }

  /**
  * Inserts the current Aircraft object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the Aircraft object already have an ID?
    if ( is_null( $this->callsign ) ) trigger_error ( "Aircraft::insert(): Attempt to insert an Aircraft object that does not have its callsign property set (to $this->callsign).", E_USER_ERROR );

    // Insert the Aircraft
    $st = DB::query("INSERT INTO aircrafts (callsign, model) VALUES (:callsign, :model)", array(
        ":model" => $this->model,
        ":callsign" => $this->callsign,
    ));

    return $st->rowCount();
  }

  /**
  * Updates the current Aircraft object in the database.
  */
  public function update() {
    // Does the Aircraft object have an ID?
    if ( is_null( $this->callsign ) ) trigger_error ( "Aircraft::update(): Attempt to update an Aircraft object that does not have its callsign property set.", E_USER_ERROR );

    // Update the Aircraft
    $st = DB::query("UPDATE aircrafts SET model=:model, callsign = :callsign WHERE callsign = :old_callsign", array(
        ":model" => $this->model,
        ":callsign" => $this->callsign,
        ":old_callsign" => isset($this->old_callsign) ? $this->old_callsign : $this->callsign,
      ));

    return $st->rowCount();
  }

  /**
  * Deletes the current Aircraft object from the database.
  */
  public function delete() {
    // Does the Aircraft object have an ID?
    if ( is_null( $this->callsign ) ) trigger_error ( "Aircraft::delete(): Attempt to delete an Aircraft object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Aircraft
    DB::query( "DELETE FROM aircrafts WHERE callsign = :callsign LIMIT 1", array(":callsign" => $this->callsign));
  }
}
