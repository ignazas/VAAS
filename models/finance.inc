<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Finance
{

  public $contact_id = null;
  public $entry_fee = null;
  public $member_fee = null;
  public $labor_fee = null;
  public $house_fee = null;
  public $electricity_fee = null;
  public $airworthiness_fee = null;
  public $insurance_fee = null;
  public $casco_fee = null;
  public $flight_fee = null;
  public $debt_fee = null;
  public $fee_notes = null;
  public $fee_last_updated = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (isset($data['contact_id'])) $this->contact_id = $data['contact_id'];
    if (isset($data['entry_fee'])) $this->entry_fee = $data['entry_fee'];
    if (isset($data['member_fee'])) $this->member_fee = $data['member_fee'];
    if (isset($data['labor_fee'])) $this->labor_fee = $data['labor_fee'];
    if (isset($data['house_fee'])) $this->house_fee = $data['house_fee'];
    if (isset($data['electricity_fee'])) $this->electricity_fee = $data['electricity_fee'];
    if (isset($data['airworthiness_fee'])) $this->airworthiness_fee = $data['airworthiness_fee'];
    if (isset($data['insurance_fee'])) $this->insurance_fee = $data['insurance_fee'];
    if (isset($data['casco_fee'])) $this->casco_fee = $data['casco_fee'];
    if (isset($data['flight_fee'])) $this->flight_fee = $data['flight_fee'];
    if (isset($data['debt_fee'])) $this->debt_fee = $data['debt_fee'];
    if (isset($data['fee_notes'])) $this->fee_notes = $data['fee_notes'];
    if (isset($data['fee_last_updated'])) $this->fee_last_updated = $data['fee_last_updated'];
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
  * Returns an Finance object matching the given article ID
  *
  * @param int The article ID
  * @return Finance|false The article object, or false if the record was not found or there was a problem
  */
  public static function getByUserId($id) {
    $st = DB::query("SELECT d.* FROM vak_contxtd_debt d INNER JOIN jos_contxtd_details cd ON cd.id=d.contact_id INNER JOIN jos_users u ON cd.user_id=u.id WHERE u.id = :id", array(":id" => $id));
    if ($row = $st->fetch())
        return new Finance($row);
    else {
      require_once dirname(__FILE__) . '/user.inc';
      if (User::Get($id)) //create context in the same go, if there is none and try again
        return Finance::getByUserId($id);
    }
    return NULL;
  }

  public static function get($id) {
    $st = DB::query("SELECT d.*, u.*, cd.user_id FROM vak_contxtd_debt d INNER JOIN jos_contxtd_details cd ON cd.id=d.contact_id INNER JOIN jos_users u ON cd.user_id=u.id WHERE d.contact_id = :contact_id", array(":contact_id" => $id));
    if ($row = $st->fetch()) {
      $f = new Finance($row);
      require_once dirname(__FILE__) . '/user.inc';
      $f->user = new User($row);
      $f->user->id = $row['user_id'];
      return $f;
    }
    return NULL;
  }

  public static function get_payments($id) {
    $st = DB::query("SELECT d.* FROM vak_balance_journal d INNER JOIN jos_contxtd_details cd ON cd.id=d.contact_id INNER JOIN jos_users u ON cd.user_id=u.id WHERE d.contact_id = :contact_id ORDER BY d.fee_updated DESC", array(":contact_id" => $id));
    if ($row = $st->fetchAll()) {
      return $row;
    }
    return NULL;
  }

  /**
  * Returns all (or a range of) Finance objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of Finance objects; totalRows => Total number of articles
  */
  public static function getList($numRows=1000000, $fromRow=0, $order="u.name", $filter = NULL) {
    require_once dirname(__FILE__) . '/user.inc';

    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS d.*, u.*, cd.user_id FROM vak_contxtd_debt d INNER JOIN jos_contxtd_details cd ON cd.id=d.contact_id INNER JOIN jos_users u ON cd.user_id=u.id WHERE u.deleted IS NULL" . (!empty($filter) ? " AND " . $filter : NULL) . " ORDER BY $order LIMIT $fromRow, $numRows");

    $list = array();
    while ($row = $st->fetch()) {
      $f = new Finance($row);
      $f->user = new User($row);
      $f->user->id = $row['user_id'];
      $list[] = $f;
    }

    // Now get the total number of articles that matched the criteria
    $totalRows = DB::fetch("SELECT FOUND_ROWS() AS totalRows");

    return array ( "results" => $list, "totalRows" => $totalRows['totalRows'] );
  }

  private function insert_journal() {
    require_once dirname(__FILE__) . '/../helpers/user.inc';

    // Insert the Finance
    $st = DB::query("INSERT INTO vak_balance_journal (contact_id,entry_fee,member_fee,labor_fee,house_fee,electricity_fee,airworthiness_fee,insurance_fee,casco_fee,flight_fee,debt_fee,fee_updated,fee_notes,admin_user_id)
    VALUES (:contact_id,:entry_fee,:member_fee,:labor_fee,:house_fee,:electricity_fee,:airworthiness_fee,:insurance_fee,:casco_fee,:flight_fee,:debt_fee,:fee_updated,:fee_notes,:admin_user_id)", array(
      ':contact_id' => intval($this->contact_id),
      ':entry_fee' => !isset($this->entry_fee) || $this->entry_fee == '' ? PDO::PARAM_NULL : floatval($this->entry_fee),
      ':member_fee' => !isset($this->member_fee) || $this->member_fee == '' ? PDO::PARAM_NULL : floatval($this->member_fee),
      ':labor_fee' => !isset($this->labor_fee) || $this->labor_fee == '' ? PDO::PARAM_NULL : floatval($this->labor_fee),
      ':house_fee' => !isset($this->house_fee) || $this->house_fee == '' ? PDO::PARAM_NULL : floatval($this->house_fee),
      ':electricity_fee' => !isset($this->electricity_fee) || $this->electricity_fee == '' ? PDO::PARAM_NULL : floatval($this->electricity_fee),
      ':airworthiness_fee' => !isset($this->airworthiness_fee) || $this->airworthiness_fee == '' ? PDO::PARAM_NULL : floatval($this->airworthiness_fee),
      ':insurance_fee' => !isset($this->insurance_fee) || $this->insurance_fee == '' ? PDO::PARAM_NULL : floatval($this->insurance_fee),
      ':casco_fee' => !isset($this->casco_fee) || $this->casco_fee == '' ? PDO::PARAM_NULL : floatval($this->casco_fee),
      ':flight_fee' => !isset($this->flight_fee) || $this->flight_fee == '' ? PDO::PARAM_NULL : floatval($this->flight_fee),
      ':debt_fee' => !isset($this->debt_fee) || $this->debt_fee == '' ? PDO::PARAM_NULL : floatval($this->debt_fee),
      ':fee_updated' => $this->fee_last_updated,
      ':fee_notes' => $this->fee_notes,
      ':admin_user_id' => UserHelper::get_id(),
    ));
  }

  /**
  * Inserts the current Finance object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the Finance object already have an ID?
    if (is_null($this->contact_id)) trigger_error ( "Finance::insert(): Attempt to insert an Finance object that does not have its contact_id property set (to $this->contact_id).", E_USER_ERROR );

    // Insert the Finance
    list($usec, $sec) = explode(' ', microtime());
    $usec = str_replace("0.", ".", $usec);
    $this->fee_last_updated = date('Y-m-d H:i:s', $sec).$usec;
    $st = DB::query("INSERT INTO vak_contxtd_debt (contact_id,entry_fee,member_fee,labor_fee,house_fee,electricity_fee,airworthiness_fee,insurance_fee,casco_fee,flight_fee,debt_fee,fee_last_updated,fee_notes)
    VALUES (:contact_id,:entry_fee,:member_fee,:labor_fee,:house_fee,:electricity_fee,:airworthiness_fee,:insurance_fee,:casco_fee,:flight_fee,:debt_fee,:fee_last_updated,:fee_notes)", array(
      ':contact_id' => intval($this->contact_id),
      ':entry_fee' => !isset($this->entry_fee) || $this->entry_fee == '' ? PDO::PARAM_NULL : floatval($this->entry_fee),
      ':member_fee' => !isset($this->member_fee) || $this->member_fee == '' ? PDO::PARAM_NULL : floatval($this->member_fee),
      ':labor_fee' => !isset($this->labor_fee) || $this->labor_fee == '' ? PDO::PARAM_NULL : floatval($this->labor_fee),
      ':house_fee' => !isset($this->house_fee) || $this->house_fee == '' ? PDO::PARAM_NULL : floatval($this->house_fee),
      ':electricity_fee' => !isset($this->electricity_fee) || $this->electricity_fee == '' ? PDO::PARAM_NULL : floatval($this->electricity_fee),
      ':airworthiness_fee' => !isset($this->airworthiness_fee) || $this->airworthiness_fee == '' ? PDO::PARAM_NULL : floatval($this->airworthiness_fee),
      ':insurance_fee' => !isset($this->insurance_fee) || $this->insurance_fee == '' ? PDO::PARAM_NULL : floatval($this->insurance_fee),
      ':casco_fee' => !isset($this->casco_fee) || $this->casco_fee == '' ? PDO::PARAM_NULL : floatval($this->casco_fee),
      ':flight_fee' => !isset($this->flight_fee) || $this->flight_fee == '' ? PDO::PARAM_NULL : floatval($this->flight_fee),
      ':debt_fee' => !isset($this->debt_fee) || $this->debt_fee == '' ? PDO::PARAM_NULL : floatval($this->debt_fee),
      ':fee_last_updated' => $this->fee_last_updated,
      ':fee_notes' => $this->fee_notes,
    ));

    $this->insert_journal();

    return $st->rowCount();
  }

  /**
  * Updates the current Finance object in the database.
  */
  public function update() {
    // Does the Finance object have an ID?
    if (is_null($this->contact_id)) trigger_error ( "Finance::update(): Attempt to update an Finance object that does not have its contact_id property set.", E_USER_ERROR );

    // Update the Finance
    list($usec, $sec) = explode(' ', microtime());
    $usec = str_replace("0.", ".", $usec);
    $this->fee_last_updated = date('Y-m-d H:i:s', $sec).$usec;
    $st = DB::query("UPDATE vak_contxtd_debt SET entry_fee=:entry_fee,member_fee=:member_fee,labor_fee=:labor_fee,house_fee=:house_fee,electricity_fee=:electricity_fee,airworthiness_fee=:airworthiness_fee,insurance_fee=:insurance_fee,casco_fee=:casco_fee,flight_fee=:flight_fee,debt_fee=:debt_fee,fee_last_updated=:fee_last_updated,fee_notes=:fee_notes WHERE contact_id = :contact_id", array(
            ':contact_id' => intval($this->contact_id),
            ':entry_fee' => !isset($this->entry_fee) || $this->entry_fee == '' ? PDO::PARAM_NULL : floatval($this->entry_fee),
            ':member_fee' => !isset($this->member_fee) || $this->member_fee == '' ? PDO::PARAM_NULL : floatval($this->member_fee),
            ':labor_fee' => !isset($this->labor_fee) || $this->labor_fee == '' ? PDO::PARAM_NULL : floatval($this->labor_fee),
            ':house_fee' => !isset($this->house_fee) || $this->house_fee == '' ? PDO::PARAM_NULL : floatval($this->house_fee),
            ':electricity_fee' => !isset($this->electricity_fee) || $this->electricity_fee == '' ? PDO::PARAM_NULL : floatval($this->electricity_fee),
            ':airworthiness_fee' => !isset($this->airworthiness_fee) || $this->airworthiness_fee == '' ? PDO::PARAM_NULL : floatval($this->airworthiness_fee),
            ':insurance_fee' => !isset($this->insurance_fee) || $this->insurance_fee == '' ? PDO::PARAM_NULL : floatval($this->insurance_fee),
            ':casco_fee' => !isset($this->casco_fee) || $this->casco_fee == '' ? PDO::PARAM_NULL : floatval($this->casco_fee),
            ':flight_fee' => !isset($this->flight_fee) || $this->flight_fee == '' ? PDO::PARAM_NULL : floatval($this->flight_fee),
            ':debt_fee' => !isset($this->debt_fee) || $this->debt_fee == '' ? PDO::PARAM_NULL : floatval($this->debt_fee),
            ':fee_last_updated' => $this->fee_last_updated,
            ':fee_notes' => $this->fee_notes,
          ));

    $this->insert_journal();

    return $st->rowCount();
  }

  /**
  * Deletes the current Finance object from the database.
  */
  public function delete() {
    // Does the Finance object have an ID?
    if (is_null($this->contact_id)) trigger_error ( "Finance::delete(): Attempt to delete an Finance object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Finance
    DB::query( "DELETE FROM vak_contxtd_debt WHERE contact_id = :contact_id LIMIT 1", array(":contact_id" => $this->contact_id));
  }
}
