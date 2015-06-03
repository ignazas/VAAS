<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Aircraft
{
  public $id = null;
  public $name = null;
  public $reg_num = null;
  public $manuf_date = null;
  public $serial_num = null;
  public $first_pilot = null;
  public $second_pilot = null;
  public $third_pilot = null;
  public $remarks = null;
  public $moh_date = null;
  public $time_since_new = null;
  public $flights_since_new = null;
  public $time_since_mo = null;
  public $flights_since_mo = null;
  public $time_left = null;
  public $flights_left = null;
  public $time_last_year = null;
  public $flights_last_year = null;
  public $coa_expiry_date = null;
  public $civ_insur_expiry_date = null;
  public $kasko_insur_expiry_date = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct($data=array()) {
    if (isset($data['id'])) $this->id = $data['id'];
    if (isset($data['name'])) $this->name = $data['name'];
    if (isset($data['reg_num'])) $this->reg_num = $data['reg_num'];
    if (isset($data['manuf_date'])) $this->manuf_date = $data['manuf_date'];
    if (isset($data['serial_num'])) $this->serial_num = $data['serial_num'];
    if (isset($data['first_pilot'])) $this->first_pilot = $data['first_pilot'];
    if (isset($data['second_pilot'])) $this->second_pilot = $data['second_pilot'];
    if (isset($data['third_pilot'])) $this->third_pilot = $data['third_pilot'];
    if (isset($data['remarks'])) $this->remarks = $data['remarks'];
    if (isset($data['moh_date'])) $this->moh_date = $data['moh_date'];
    if (isset($data['time_since_new'])) $this->time_since_new = $data['time_since_new'];
    if (isset($data['flights_since_new'])) $this->flights_since_new = $data['flights_since_new'];
    if (isset($data['time_since_mo'])) $this->time_since_mo = $data['time_since_mo'];
    if (isset($data['flights_since_mo'])) $this->flights_since_mo = $data['flights_since_mo'];
    if (isset($data['time_left'])) $this->time_left = $data['time_left'];
    if (isset($data['flights_left'])) $this->flights_left = $data['flights_left'];
    if (isset($data['time_last_year'])) $this->time_last_year = $data['time_last_year'];
    if (isset($data['flights_last_year'])) $this->flights_last_year = $data['flights_last_year'];
    if (isset($data['coa_expiry_date'])) $this->coa_expiry_date = $data['coa_expiry_date'];
    if (isset($data['civ_insur_expiry_date'])) $this->civ_insur_expiry_date = $data['civ_insur_expiry_date'];
    if (isset($data['kasko_insur_expiry_date'])) $this->kasko_insur_expiry_date = $data['kasko_insur_expiry_date'];
  }

  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */
  public function storeFormValues ($params) {
    // Store all the parameters
    $this->__construct($params);
  }

  /**
  * Returns an Aircraft object matching the given article ID
  *
  * @param int The article ID
  * @return Aircraft|false The article object, or false if the record was not found or there was a problem
  */
  public static function getById($id) {
    $st = DB::query("SELECT * FROM vak_aircrafts WHERE id = :id", array(":id" => $id));
    if ($row = $st->fetch())
        return new Aircraft($row);
    return NULL;
  }

  /**
  * Returns all (or a range of) Aircraft objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of Aircraft objects; totalRows => Total number of articles
  */
  public static function getList($numRows=1000000, $order="reg_num", $filter = NULL) {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS *
                     FROM vak_aircrafts
                     WHERE deleted IS NULL" . (!empty($filter) ? " AND " . $filter : NULL) . "
                     ORDER BY $order LIMIT $numRows");

    $list = array();
    while ($row = $st->fetch()) {
      $list[] = new Aircraft($row);
    }

    // Now get the total number of articles that matched the criteria
    $totalRows = DB::fetch("SELECT FOUND_ROWS() AS totalRows");

    return array ( "results" => $list, "totalRows" => $totalRows['totalRows'] );
  }

  /**
  * Inserts the current Aircraft object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the Aircraft object already have an ID?
    if (!is_null($this->id)) trigger_error ( "Aircraft::insert(): Attempt to insert an Aircraft object that does have its id property set (to $this->id).", E_USER_ERROR );

    // Insert the Aircraft
    $this->id = DB::insert("INSERT INTO vak_aircrafts (`name`, `reg_num`, `manuf_date`, `serial_num`, `first_pilot`, `second_pilot`, `third_pilot`, `remarks`, `moh_date`, `time_since_new`, `flights_since_new`, `time_since_mo`, `flights_since_mo`, `time_left`, `flights_left`, `time_last_year`, `flights_last_year`, `coa_expiry_date`, `civ_insur_expiry_date`, `kasko_insur_expiry_date`) VALUES (:name, :reg_num, :manuf_date, :serial_num, :first_pilot, :second_pilot, :third_pilot, :remarks, " . DB::date_as_string($this->moh_date) . ", :time_since_new, :flights_since_new, :time_since_mo, :flights_since_mo, :time_left, :flights_left, :time_last_year, :flights_last_year, " . DB::date_as_string($this->coa_expiry_date) . ", " . DB::date_as_string($this->civ_insur_expiry_date) . ", " . DB::date_as_string($this->kasko_insur_expiry_date) . ")", array(
            ':name' => $this->name,
            ':reg_num' => $this->reg_num,
            ':manuf_date' => $this->manuf_date,
            ':serial_num' => $this->serial_num,
            ':first_pilot' => $this->first_pilot,
            ':second_pilot' => $this->second_pilot,
            ':third_pilot' => $this->third_pilot,
            ':remarks' => $this->remarks,
            ':time_since_new' => DB::null_if_empty($this->time_since_new),
            ':flights_since_new' => DB::null_if_empty($this->flights_since_new),
            ':time_since_mo' => DB::null_if_empty($this->time_since_mo),
            ':flights_since_mo' => DB::null_if_empty($this->flights_since_mo),
            ':time_left' => DB::null_if_empty($this->time_left),
            ':flights_left' => DB::null_if_empty($this->flights_left),
            ':time_last_year' => DB::null_if_empty($this->time_last_year),
            ':flights_last_year' => DB::null_if_empty($this->flights_last_year),
          ));

    return !empty($this->id);
  }

  /**
  * Updates the current Aircraft object in the database.
  */
  public function update() {
    // Does the Aircraft object have an ID?
    if (is_null($this->id)) trigger_error ( "Aircraft::update(): Attempt to update an Aircraft object that does not have its id property set.", E_USER_ERROR );

    // Update the Aircraft
    $st = DB::query("UPDATE vak_aircrafts SET `name` = :name, `reg_num` = :reg_num, `manuf_date` = " . DB::date_as_string($this->manuf_date) . ", `serial_num` = :serial_num, `first_pilot` = :first_pilot, `second_pilot` = :second_pilot, `third_pilot` = :third_pilot, `remarks` = :remarks, `moh_date` = " . DB::date_as_string($this->moh_date) . ", `time_since_new` = :time_since_new, `flights_since_new` = :flights_since_new, `time_since_mo` = :time_since_mo, `flights_since_mo` = :flights_since_mo, `time_left` = :time_left, `flights_left` = :flights_left, `time_last_year` = :time_last_year, `flights_last_year` = :flights_last_year, `coa_expiry_date` = " . DB::date_as_string($this->coa_expiry_date) . ", `civ_insur_expiry_date` = " . DB::date_as_string($this->civ_insur_expiry_date) . ", `kasko_insur_expiry_date` = " . DB::date_as_string($this->kasko_insur_expiry_date) . " WHERE id = :id", array(
            ':name' => $this->name,
            ':reg_num' => $this->reg_num,
            ':serial_num' => $this->serial_num,
            ':first_pilot' => $this->first_pilot,
            ':second_pilot' => $this->second_pilot,
            ':third_pilot' => $this->third_pilot,
            ':remarks' => $this->remarks,
            ':time_since_new' => DB::null_if_empty($this->time_since_new),
            ':flights_since_new' => DB::null_if_empty($this->flights_since_new),
            ':time_since_mo' => DB::null_if_empty($this->time_since_mo),
            ':flights_since_mo' => DB::null_if_empty($this->flights_since_mo),
            ':time_left' => DB::null_if_empty($this->time_left),
            ':flights_left' => DB::null_if_empty($this->flights_left),
            ':time_last_year' => DB::null_if_empty($this->time_last_year),
            ':flights_last_year' => DB::null_if_empty($this->flights_last_year),
            ':id' => $this->id,
      ));

    return TRUE;
  }

  /**
  * Deletes the current Aircraft object from the database.
  */
  public function delete() {
    // Does the Aircraft object have an ID?
    if (is_null($this->id)) trigger_error("Aircraft::delete(): Attempt to delete an Aircraft object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Aircraft
    DB::query("UPDATE `vak_aircrafts` SET `deleted`=" . DB::date_as_string(time()) . " WHERE id = :id LIMIT 1", array(":id" => $this->id));
    //DB::query( "DELETE FROM vak_aircrafts WHERE id = :id LIMIT 1", array(":id" => $this->id));
  }
}
