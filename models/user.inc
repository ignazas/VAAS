<?php

require_once dirname(__FILE__) . '/../helpers/db.inc';

class User {
    public $id;
    public $name;
    public $username;
    public $usertype;
    public $password;
    public $email;
    public $registerDate;
    public $lastvisitDate;
    public $discount;
    public $instructor;
    public $instructor_id;
    public $licenseNo;
    public $licenseValidTill;
    public $healthNo;
    public $healthValidTill;

    public $contact_id;
    public $telephone1;
    public $telephone2;
    public $website;
    public $avatar;
    public $birthdate;
    public $email_to;
    public $con_position;
    public $catid;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (isset($data['id'])) $this->id = $data['id'];
    if (isset($data['name'])) $this->name = $data['name'];
    if (isset($data['username'])) $this->username = $data['username'];
    if (isset($data['usertype'])) $this->usertype = $data['usertype'];
    if (isset($data['password'])) $this->password = $data['password'];
    if (isset($data['email'])) $this->email = $data['email'];
    if (isset($data['registerDate'])) $this->registerDate = $data['registerDate'];
    if (isset($data['lastvisitDate'])) $this->lastvisitDate = $data['lastvisitDate'];
    if (isset($data['discount'])) $this->discount = $data['discount'];
    if (isset($data['instructor'])) $this->instructor = $data['instructor'];
    if (isset($data['instructor_id'])) $this->instructor_id = $data['instructor_id'];
    if (isset($data['licenseNo'])) $this->licenseNo = $data['licenseNo'];
    if (isset($data['licenseValidTill'])) $this->licenseValidTill = $data['licenseValidTill'];
    if (isset($data['healthNo'])) $this->healthNo = $data['healthNo'];
    if (isset($data['healthValidTill'])) $this->healthValidTill = $data['healthValidTill'];

    if (isset($data['contact_id'])) $this->contact_id = $data['contact_id'];
    if (isset($data['telephone1'])) $this->telephone1 = $data['telephone1'];
    if (isset($data['telephone2'])) $this->telephone2 = $data['telephone2'];
    if (isset($data['website'])) $this->website = $data['website'];
    if (isset($data['avatar'])) $this->avatar = $data['avatar'];
    if (!empty($data['birthdate']) && trim($data['birthdate'], '0-')) $this->birthdate = $data['birthdate'];
    if (isset($data['email_to'])) $this->email_to = $data['email_to'];
    if (isset($data['con_position'])) $this->con_position = $data['con_position'];
    if (isset($data['catid'])) $this->catid = $data['catid'];
  }

    public static function Get($id) {
        if (!empty($id)) {
          $data = DB::fetch("
                SELECT u.*,
                    ud.telephone1, ud.telephone2, ud.website, ud.avatar, ud.birthdate, ud.email_to, ud.con_position, ud.id 'contact_id', ud.catid
                FROM jos_users u
                LEFT JOIN jos_contxtd_details ud ON u.id = ud.user_id
                WHERE
                    u.id = :id", array(':id' => $id));
          if (!empty($data)) {
            if (!isset($data['contact_id'])) {
              //that means context is not created! need to create one
              $data['contact_id'] = DB::insert("INSERT INTO jos_contxtd_details (user_id, email_to, params, name) VALUES (:user_id, :email_to, '', :name)", array(
                  ':email_to' => $data['email'],
                  ':user_id' => $id,
                  ':name' => $data['name']
                ));
            }
            return new User($data);
          }
        }
        return NULL;
    }

    public static function get_by_username($username) {
        if (!empty($username)) {
            $data = DB::fetch("
                SELECT u.*,
                    ud.telephone1, ud.telephone2, ud.website, ud.avatar, ud.birthdate, ud.email_to, ud.con_position, ud.id 'contact_id', ud.catid
                FROM jos_users u
                LEFT JOIN jos_contxtd_details ud ON u.id = ud.user_id
                WHERE
                    u.deleted IS NULL AND (u.username = :username OR u.email = :username)", array(':username' => $username));
            if (!empty($data))
              return new User($data);
        }
        return NULL;
    }

    public static function Put($id, $values) {
        if (!empty($id) && !empty($values)) {
            $query_user = NULL;
            $query_context = NULL;
            foreach ($values as $key => $value) {
              if (in_array($key, array('name', 'username', 'email', 'password', 'usertype', 'block', 'sendEmail',
                    'gid', 'registerDate', 'lastvisitDate', 'activation', 'params', 'discount', 'instructor', 'instructor_id'))) {
                $query_user .= (!empty($query_user) ? ',' : NULL) . "`$key`='" . $value . "'";
                if ($key == 'email') $query_context .= (!empty($query_context) ? ',' : NULL) . "`email_to`='" . $value . "'";
              }
              else if (in_array($key, array('licenseNo', 'licenseValidTill', 'healthNo', 'healthValidTill'))) {
                $query_user .= (!empty($query_user) ? ',' : NULL) . "`$key`=" . DB::date_as_string($value);
              }
              else
                $query_context .= (!empty($query_context) ? ',' : NULL) . "`$key`='" . $value . "'";
            }
            if ($query_user)
                DB::query("UPDATE `jos_users` SET $query_user WHERE `id`=:id", array(':id' => $id));

            if ($query_context)
                DB::query("UPDATE `jos_contxtd_details` SET $query_context WHERE `user_id`=:id", array(':id' => $id));

            return TRUE;
        }
        return FALSE;
    }

  /**
  * Returns all (or a range of) Article objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of Article objects; totalRows => Total number of articles
  */
    public static function getList($numRows=1000000, $order="u.name", $filter = NULL) {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS
                       u.*,
                       ud.telephone1, ud.telephone2, ud.website, ud.avatar, ud.birthdate, ud.email_to, ud.con_position, ud.id 'contact_id', ud.catid
                     FROM jos_users u LEFT OUTER JOIN jos_contxtd_details ud ON u.id=ud.user_id
                     WHERE deleted IS NULL" . (!empty($filter) ? " AND " . $filter : NULL) . "
                     ORDER BY " . ltrim($order, '-+') . ($order[0] == '-' ? ' DESC' : ' ASC') . "
                     LIMIT $numRows");

    $list = array();
    while ( $row = $st->fetch() ) {
      $user = new User( $row );
      $list[] = $user;
    }

    // Now get the total number of articles that matched the criteria
    $totalRows = DB::fetch("SELECT FOUND_ROWS() AS totalRows");

    return array ( "results" => $list, "totalRows" => $totalRows['totalRows'] );
  }

  /**
  * Inserts the current User object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the User object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "User::insert(): Attempt to insert an User object that already has its ID property set (to $this->id).", E_USER_ERROR );

    $this->id = DB::insert("INSERT INTO jos_users (name, username, usertype, password, email, registerDate, params, instructor, instructor_id, licenseNo, licenseValidTill, healthNo, healthValidTill) VALUES (:name, :username, :usertype, :password, :email, " . DB::date_as_string(time()) . ", '', :instructor, :instructor_id, :licenseNo, " . DB::date_as_string($this->licenseValidTill) . ", :healthNo, " . DB::date_as_string($this->healthValidTill) . ")", array(
                  ':name' => $this->name,
                  ':username' => $this->username,
                  ':usertype' => $this->usertype,
                  ':password' => $this->password,
                  ':email' => $this->email,
                  ':instructor' => empty($this->instructor) ? 0 : 1,
                  ':instructor_id' => $this->instructor_id,
                  ':licenseNo' => $this->licenseNo,
                  ':healthNo' => $this->healthNo,
                ));

    $this->contact_id = DB::insert("INSERT INTO jos_contxtd_details (name, user_id, telephone1, telephone2, website, avatar, birthdate, email_to, con_position, params, catid) VALUES (:name, :user_id, :telephone1, :telephone2, :website, :avatar, " . DB::date_as_string($this->birthdate) . ", :email_to, :con_position, '', :catid)", array(
        ':name' => $this->name,
        ':telephone1' => $this->telephone1,
        ':telephone2' => $this->telephone2,
        ':website' => $this->website,
        ':avatar' => $this->avatar,
        ':email_to' => $this->email_to,
        ':con_position' => $this->con_position,
        ':user_id' => $this->id,
        ':catid' => $this->catid,
      ));

    return !empty($this->id);
  }

  /**
  * Deletes the current user object from the database.
  */
  public function delete() {
    // Does the user object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "User::delete(): Attempt to delete an User object that does not have its id property set.", E_USER_ERROR );

    // Delete the User
    DB::query("UPDATE `jos_users` SET `deleted`=" . DB::date_as_string(time()) . " WHERE id = :id LIMIT 1", array(":id" => $this->id));
  }
}
