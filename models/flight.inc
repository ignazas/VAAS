<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';
require_once dirname(__FILE__) . '/../models/user.inc';
require_once dirname(__FILE__) . '/../models/service.inc';

class Flight
{

  public $record_id = null;
  public $date = null;
  public $instructor = null;
  public $payer = null;
  public $airplane_id = null;
  public $task = null;
  public $amount = null;
  public $price = null;
  public $duration = null;
  public $service_id = null;
  public $amount_unit = null;
  public $price_instructor = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (isset($data['record_id'])) $this->record_id = $data['record_id'];
    if (isset($data['date'])) $this->date = $data['date'];
    if (isset($data['instructor'])) $this->instructor = $data['instructor'];
    if (isset($data['payer'])) $this->payer = $data['payer'];
    if (isset($data['airplane_id'])) $this->airplane_id = $data['airplane_id'];
    if (isset($data['task'])) $this->task = $data['task'];
    if (isset($data['amount'])) $this->amount = intval($data['amount']);
    if (isset($data['price'])) $this->price = floatval($data['price']);
    if (isset($data['duration'])) $this->duration = $data['duration'];
    if (isset($data['service_id'])) $this->service_id = $data['service_id'];
    if (isset($data['amount_unit'])) $this->amount_unit = $data['amount_unit'];
    if (isset($data['price_instructor']))
      $this->price_instructor = $data['price_instructor'];
    else if (!empty($this->instructor)) {
      $instructor = User::Get($this->instructor);
      $instructorSalary = empty($this->service_id) ? NULL : Service::getById($this->service_id);
      if (!empty($instructor) && !empty($instructorSalary) && !empty($instructorSalary->price_for_instructor)) {
        if ($instructorSalary->is_price_for_duration && !empty($this->duration)) {
          $this->price_instructor = $instructorSalary->price_for_instructor * $this->duration;
        }
        else if (!$instructorSalary->is_price_for_duration && !empty($this->amount)) {
          $this->price_instructor = $instructorSalary->price_for_instructor * $this->amount;
        }
        if (!empty($this->price_instructor))
          $this->price_instructor = round($this->price_instructor);
      }
    }
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
  public static function getList( $numRows=1000000, $order = '-date', $filter = NULL) {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS f.*
                     FROM flights f
                     LEFT OUTER JOIN jos_users u ON f.payer=u.id
                     LEFT OUTER JOIN jos_users i ON f.instructor=i.id
                     LEFT OUTER JOIN vak_aircrafts a ON f.airplane_id=a.id
                     LEFT OUTER JOIN services s ON f.service_id=s.id
                     WHERE 1=1" . (!empty($filter) ? " AND " . $filter : NULL) . "
                     " . (empty($order) ? NULL : "ORDER BY " . ltrim($order, '-+') . ($order[0] == '-' ? ' DESC' : ' ASC')) .
          (!empty($numRows) ? " LIMIT $numRows" : NULL));

    $list = array();
    while ($row = $st->fetch()) {
      if (!empty($row['duration']) && gettype($row['duration']) === 'string')
        $row['duration'] = floatval($row['duration']);
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
    $this->record_id = DB::insert("INSERT INTO flights (date, airplane_id, instructor, payer, task, amount, price, service_id, duration, amount_unit, price_instructor)
    VALUES (" . DB::date_as_string($this->date) . ", :airplane_id, :instructor, :payer, :task, :amount, :price, :service_id, :duration, :amount_unit, :price_instructor)", array(
        ":airplane_id" => $this->airplane_id,
        ":instructor" => DB::null_if_empty($this->instructor),
        ":payer" => $this->payer,
        ":task" => DB::null_if_empty($this->task),
        ":amount" => DB::null_if_empty($this->amount),
        ":price" => DB::null_if_empty($this->price),
        ":service_id" => DB::null_if_empty($this->service_id),
        ":duration" => DB::null_if_empty($this->duration),
        ":amount_unit" => DB::null_if_empty($this->amount_unit),
        ":price_instructor" => DB::null_if_empty($this->price_instructor),
    ));

    return !empty($this->record_id);
  }

  /**
  * Updates the current Flight object in the database.
  */
  public function update() {
    // Does the Flight object have an ID?
    if (is_null($this->record_id)) trigger_error ( "Flight::update(): Attempt to update an Flight object that does not have its record_id property set.", E_USER_ERROR );

    // Update the Flight
    $st = DB::query("UPDATE flights SET date=" . DB::date_as_string($this->date) . ", airplane_id=:airplane_id, instructor=:instructor, payer=:payer, task=:task, amount=:amount, price=:price, service_id=:service_id, duration=:duration, amount_unit=:amount_unit, price_instructor=:price_instructor WHERE record_id = :record_id", array(
        ":airplane_id" => $this->airplane_id,
        ":instructor" => DB::null_if_empty($this->instructor),
        ":payer" => $this->payer,
        ":task" => DB::null_if_empty($this->task),
        ":amount" => DB::null_if_empty($this->amount),
        ":price" => DB::null_if_empty($this->price),
        ":service_id" => DB::null_if_empty($this->service_id),
        ":duration" => DB::null_if_empty($this->duration),
        ":amount_unit" => DB::null_if_empty($this->amount_unit),
        ":price_instructor" => DB::null_if_empty($this->price_instructor),
        ":record_id" => $this->record_id,
      ));

    return TRUE;//$st->rowCount();
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
