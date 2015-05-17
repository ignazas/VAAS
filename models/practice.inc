<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Practice
{
  public $id = null;
  public $weight = null;
  public $no = null;
  public $phase_no = null;
  public $title = null;
  public $flight_with_instructor_count = null;
  public $flight_with_instructor_time = null;
  public $flight_individual_count = null;
  public $flight_individual_time = null;
  public $flight_box_count = null;
  public $flight_box_time = null;
  public $flight_zone_count = null;
  public $flight_zone_time = null;
  public $flight_route_count = null;
  public $flight_route_time = null;
  public $briefing = null;
  public $description = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (isset($data['id'])) $this->id = $data['id'];
    if (isset($data['weight'])) $this->weight = $data['weight'];
    if (isset($data['no'])) $this->no = $data['no'];
    if (isset($data['phase_no'])) $this->phase_no = $data['phase_no'];
    if (isset($data['title'])) $this->title = $data['title'];
    if (isset($data['flight_with_instructor_count'])) $this->flight_with_instructor_count = $data['flight_with_instructor_count'];
    if (isset($data['flight_with_instructor_time'])) $this->flight_with_instructor_time = $data['flight_with_instructor_time'];
    if (isset($data['flight_individual_count'])) $this->flight_individual_count = $data['flight_individual_count'];
    if (isset($data['flight_individual_time'])) $this->flight_individual_time = $data['flight_individual_time'];
    if (isset($data['flight_box_count'])) $this->flight_box_count = $data['flight_box_count'];
    if (isset($data['flight_box_time'])) $this->flight_box_time = $data['flight_box_time'];
    if (isset($data['flight_zone_count'])) $this->flight_zone_count = $data['flight_zone_count'];
    if (isset($data['flight_zone_time'])) $this->flight_zone_time = $data['flight_zone_time'];
    if (isset($data['flight_route_count'])) $this->flight_route_count = $data['flight_route_count'];
    if (isset($data['flight_route_time'])) $this->flight_route_time = $data['flight_route_time'];
    if (isset($data['briefing'])) $this->briefing = $data['briefing'];
    if (isset($data['description'])) $this->description = $data['description'];
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
  * Returns an Practice object matching the given article ID
  *
  * @param int The article ID
  * @return Practice|false The article object, or false if the record was not found or there was a problem
  */
  public static function getById($id) {
    $st = DB::query("SELECT * FROM practice WHERE id = :id", array(":id" => $id));
    if ($row = $st->fetch())
        return new Practice( $row );
    return NULL;
  }

  /**
  * Returns all (or a range of) Practice objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of Practice objects; totalRows => Total number of articles
  */
  public static function getList( $numRows=1000000, $order = 'weight') {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS * FROM practice" .
          (!empty($order) ? (' ORDER BY ' . ltrim($order, '-+') . ($order[0] == '-' ? ' DESC' : ' ASC')) : ' ORDER BY `weight`') .
          (!empty($numRows) ? " LIMIT $numRows" : NULL));

    $list = array();
    while ($row = $st->fetch()) {
      $list[] = new Practice($row);
    }

    // Now get the total number of articles that matched the criteria
    $totalRows = DB::fetch("SELECT FOUND_ROWS() AS totalRows");

    return array ( "results" => $list, "totalRows" => $totalRows['totalRows'] );
  }

  /**
  * Inserts the current Practice object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the Practice object already have an ID?
    if (!is_null($this->id)) trigger_error ( "Practice::insert(): Attempt to insert an Practice object that does have its id property set (to $this->id).", E_USER_ERROR );

    // Insert the Practice
    $st = DB::query("INSERT INTO practice (
 `weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`,
 `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
    VALUES (
 :weight, :no, :phase_no, :title,
 :flight_with_instructor_count, :flight_with_instructor_time, :flight_individual_count, :flight_individual_time,
 :flight_box_count, :flight_box_time, :flight_zone_count, :flight_zone_time, :flight_route_count, :flight_route_time,
 :briefing, :description)", array(
        ":weight" => (int)$this->weight,
        ":no" => (int)$this->no,
        ":phase_no" => (int)$this->phase_no,
        ":title" => $this->title,
        ":flight_with_instructor_count" => (int)$this->flight_with_instructor_count,
        ":flight_with_instructor_time" => $this->flight_with_instructor_time,
        ":flight_individual_count" => (int)$this->flight_individual_count,
        ":flight_individual_time" => $this->flight_individual_time,
        ":flight_box_count" => (int)$this->flight_box_count,
        ":flight_box_time" => $this->flight_box_time,
        ":flight_zone_count" => (int)$this->flight_zone_count,
        ":flight_zone_time" => $this->flight_zone_time,
        ":flight_route_count" => (int)$this->flight_route_count,
        ":flight_route_time" => $this->flight_route_time,
        ":briefing" => $this->briefing,
        ":description" => $this->description,
    ));

    return $st->rowCount();
  }

  /**
  * Updates the current Practice object in the database.
  */
  public function update() {
    // Does the Practice object have an ID?
    if (is_null($this->id)) trigger_error ( "Practice::update(): Attempt to update an Practice object that does not have its id property set.", E_USER_ERROR );

    // Update the Practice
    $st = DB::query("UPDATE practice SET `weight`=:weight, `no`=:no, `phase_no`=:phase_no, `title`=:title,
 `flight_with_instructor_count`=:flight_with_instructor_count, `flight_with_instructor_time`=:flight_with_instructor_time, `flight_individual_count`=:flight_individual_count, `flight_individual_time`=:flight_individual_time,
 `flight_box_count`=:flight_box_count, `flight_box_time`=:flight_box_time, `flight_zone_count`=:flight_zone_count, `flight_zone_time`=:flight_zone_time, `flight_route_count`=:flight_route_count, `flight_route_time`=:flight_route_time,
 `briefing`=:briefing, `description`=:description WHERE id = :id", array(
        ":weight" => (int)$this->weight,
        ":no" => (int)$this->no,
        ":phase_no" => (int)$this->phase_no,
        ":title" => $this->title,
        ":flight_with_instructor_count" => (int)$this->flight_with_instructor_count,
        ":flight_with_instructor_time" => $this->flight_with_instructor_time,
        ":flight_individual_count" => (int)$this->flight_individual_count,
        ":flight_individual_time" => $this->flight_individual_time,
        ":flight_box_count" => (int)$this->flight_box_count,
        ":flight_box_time" => $this->flight_box_time,
        ":flight_zone_count" => (int)$this->flight_zone_count,
        ":flight_zone_time" => $this->flight_zone_time,
        ":flight_route_count" => (int)$this->flight_route_count,
        ":flight_route_time" => $this->flight_route_time,
        ":briefing" => $this->briefing,
        ":description" => $this->description,
        ":id" => (int)$this->id,
      ));

    return TRUE;//$st->rowCount();
  }

  /**
  * Deletes the current Practice object from the database.
  */
  public function delete() {
    // Does the Practice object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Practice::delete(): Attempt to delete an Practice object that does not have its id property set.", E_USER_ERROR );

    // Delete the Practice
    DB::query( "DELETE FROM practice WHERE id = :id LIMIT 1", array(":id" => $this->id));
  }
}
