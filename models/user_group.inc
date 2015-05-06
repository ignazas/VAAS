<?php

require_once dirname(__FILE__) . '/../helpers/db.inc';

class UserGroup {
    public $id;
    public $name;
    public $title;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (isset($data['id'])) $this->id = $data['id'];
    if (isset($data['name'])) $this->name = $data['name'];
    if (isset($data['title'])) $this->title = $data['title'];
  }

    public static function getById($id) {
        if (!empty($id)) {
          $data = DB::fetch("
                SELECT c.*
                FROM jos_categories c
                WHERE
                    c.id = :id", array(':id' => $id));
          if (!empty($data)) {
            return new UserGroup($data);
          }
        }
        return NULL;
    }

  /**
  * Returns all (or a range of) Article objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of Article objects; totalRows => Total number of articles
  */
  public static function getList( $numRows=1000000, $order="c.title" ) {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS
                       c.*
                     FROM jos_categories c
                     ORDER BY $order LIMIT $numRows");

    $list = array();
    while ( $row = $st->fetch() ) {
      $userGroup = new UserGroup( $row );
      $list[] = $userGroup;
    }

    // Now get the total number of articles that matched the criteria
    $totalRows = DB::fetch("SELECT FOUND_ROWS() AS totalRows");

    return array ( "results" => $list, "totalRows" => $totalRows['totalRows'] );
  }

  /**
  * Inserts the current UserGroup object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the UserGroup object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "UserGroup::insert(): Attempt to insert an UserGroup object that already has its ID property set (to $this->id).", E_USER_ERROR );

    $this->id = DB::insert("INSERT INTO jos_categories (name, title, description, params) VALUES (:name, :title, :description, :params)", array(
                  ':name' => $this->name,
                  ':title' => $this->title,
                  ':description' => '',
				  ':params' => ''
                ));
    return !empty($this->id);
  }

  /**
  * Updates the current Flight object in the database.
  */
  public function update() {
    // Does the Flight object have an ID?
    if (is_null($this->id)) trigger_error ( "UserGroup::update(): Attempt to update an UserGroup object that does not have its id property set.", E_USER_ERROR );

    // Update the Flight
    $st = DB::query("UPDATE jos_categories SET name=:name, title=:title, description=:description, params=:params WHERE id = :id", array(
        ':name' => $this->name,
        ':title' => $this->title,
        ':description' => '',
        ':params' => '',
        ":id" => $this->id,
      ));

    return TRUE;//$st->rowCount();
  }

  /**
  * Deletes the current Flight object from the database.
  */
  public function delete() {
    // Does the UserGroup object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "UserGroup::delete(): Attempt to delete an UserGroup object that does not have its id property set.", E_USER_ERROR );

    // Delete the Flight
    DB::query( "DELETE FROM jos_categories WHERE id = :id LIMIT 1", array(":id" => $this->id));
  }
}
