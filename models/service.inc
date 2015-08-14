<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Service
{

  public $id = null;
  public $title = null;
  public $is_discount = null;
  public $amount = null;
  public $description = null;
  public $is_flight = null;
  public $unit = null;
  public $amount_unit = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (!empty($data['id'])) $this->id = (int) $data['id'];
    if (isset($data['title'])) $this->title =  $data['title'];
    if (isset($data['is_discount'])) $this->is_discount = empty($data['is_discount']) ? 0 : 1;
    if (isset($data['amount'])) $this->amount = (double)$data['amount'];
    if (isset($data['description'])) $this->description = $data['description'];
    if (isset($data['is_flight'])) $this->is_flight = empty($data['is_flight']) ? 0 : 1;
    if (isset($data['unit'])) $this->unit = $data['unit'];
    if (isset($data['amount_unit'])) $this->amount_unit = (double)$data['amount_unit'];
  }

  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */
  public function storeFormValues ( $params ) {
    // Store all the parameters
    if (!isset($params['is_discount']))
      $params['is_discount'] = 0;
    if (!isset($params['is_flight']))
      $params['is_flight'] = 0;
    $this->__construct($params);
  }

  /**
  * Returns an Article object matching the given article ID
  *
  * @param int The article ID
  * @return Article|false The article object, or false if the record was not found or there was a problem
  */
  public static function getById($id) {
    $st = DB::query("SELECT * FROM `services` WHERE `id` = :id", array(":id" => $id));
    if ($row = $st->fetch())
        return new Service($row);
    return NULL;
  }

  /**
  * Returns all (or a range of) Article objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="date DESC")
  * @return Array|false A two-element array : results => array, a list of Article objects; totalRows => Total number of articles
  */
  public static function getList($numRows=1000000, $order="title", $filter = NULL) {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS *
                     FROM `services`
                     WHERE 1=1" . (!empty($filter) ? " AND " . $filter : NULL) . "
                     ORDER BY " . ltrim($order, '-+') . ($order[0] == '-' ? ' DESC' : ' ASC') . "
                     LIMIT $numRows");

    $list = array();
    while ( $row = $st->fetch() ) {
      $service = new Service($row);
      $list[] = $service;
    }

    // Now get the total number of articles that matched the criteria
    $st = DB::query("SELECT FOUND_ROWS() AS totalRows");
    $totalRows = $st->fetch();

    return array("results" => $list, "totalRows" => $totalRows['totalRows']);
  }

  /**
  * Inserts the current Article object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the Article object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "Service::insert(): Attempt to insert a Service object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the Article
    $this->id = DB::insert("INSERT INTO `services` (`title`, `is_discount`, `amount`, `description`, `is_flight`, `unit`, `amount_unit`) VALUES (:title, :is_discount, :amount, :description, :is_flight, :unit, :amount_unit)", array(
        ":title" => $this->title,
        ":amount" => $this->amount,
        ":description" => $this->description,
        ":is_discount" => empty($this->is_discount) ? 0 : 1,
        ":is_flight" => empty($this->is_flight) ? 0 : 1,
        ":unit" => DB::null_if_empty($this->unit),
        ":amount_unit" => DB::null_if_empty($this->amount_unit),
    ));

    return !empty($this->id);
  }

  /**
  * Updates the current Article object in the database.
  */
  public function update() {
    // Does the Service object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Service::update(): Attempt to update a Service object that does not have its ID property set.", E_USER_ERROR );

    // Update the Service
    $st = DB::query("UPDATE `services` SET `title`=:title, `is_discount`=:is_discount, `amount`=:amount, `description`=:description, `is_flight`=:is_flight, unit=:unit, amount_unit=:amount_unit WHERE id = :id", array(
        ":title" => $this->title,
        ":amount" => $this->amount,
        ":description" => $this->description,
        ":is_discount" => empty($this->is_discount) ? 0 : 1,
        ":is_flight" => empty($this->is_flight) ? 0 : 1,
        ":unit" => DB::null_if_empty($this->unit),
        ":amount_unit" => DB::null_if_empty($this->amount_unit),
        ":id" => $this->id,
      ));

    return TRUE;
  }

  /**
  * Deletes the current Article object from the database.
  */
  public function delete() {
    // Does the Service object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Service::delete(): Attempt to delete a Service object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Article
    DB::query( "DELETE FROM `services` WHERE id = :id LIMIT 1", array(":id" => $this->id));
  }
}
