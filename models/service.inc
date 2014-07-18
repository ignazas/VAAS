<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Service
{

  public $id = null;
  public $title = null;
  public $discount_disabled = null;
  public $amount = null;
  public $description = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (!empty($data['id'])) $this->id = (int) $data['id'];
    if (isset($data['title'])) $this->title =  $data['title'];
    if (isset($data['discount_disabled'])) $this->discount_disabled = $data['discount_disabled'];
    if (isset($data['amount'])) $this->amount = (double)$data['amount'];
    if (isset($data['description'])) $this->description = $data['description'];
  }

  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */
  public function storeFormValues ( $params ) {
    // Store all the parameters
    if (!isset($params['discount_disabled']))
      $params['discount_disabled'] = 0;
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
  public static function getList( $numRows=1000000, $order="title DESC" ) {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS * FROM `services`
            ORDER BY $order LIMIT $numRows");

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
    $this->id = DB::insert("INSERT INTO `services` (`title`, `discount_disabled`, `amount`, `description`) VALUES (:title, " . (empty($this->discount_disabled) ? 0 : 1) . ", :amount, :description)", array(
        ":title" => $this->title,
        ":amount" => $this->amount,
        ":description" => $this->description,
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
    $st = DB::query("UPDATE `services` SET `title`=:title, `discount_disabled`=" . (empty($this->discount_disabled) ? 0 : 1) . ", `amount`=:amount, `description`=:description WHERE id = :id", array(
        ":title" => $this->title,
        ":amount" => $this->amount,
        ":description" => $this->description,
        ":id" => $this->id,
      ));

    return $st->rowCount();
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
