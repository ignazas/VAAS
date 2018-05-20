<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Category
{

  public $id = null;
  public $parent_id = null;
  public $title = null;
  public $name = null;
  public $section = null;
  public $ordering = null;
  //public $image = null;
  //public $image_position = null;
  public $description = null;
  public $published = null;
  //public $checked_out = null;
  //public $checked_out_time = null;
  public $editor = null;
  public $access = null;
  public $count = null;
  public $params = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
    if ( isset( $data['parent_id'] ) ) $this->parent_id = (int) $data['parent_id'];
    if ( isset( $data['title'] ) ) $this->title =  $data['title'];
    if ( isset( $data['name'] ) ) $this->name = $data['name'];
    if ( isset( $data['section'] ) ) $this->section = $data['section'];
    if ( isset( $data['ordering'] ) ) $this->ordering = $data['ordering'];
    //if ( isset( $data['image'] ) ) $this->image = $data['image'];
    //if ( isset( $data['image_position'] ) ) $this->image_position = $data['image_position'];
    if ( isset( $data['description'] ) ) $this->description = $data['description'];
    if ( isset( $data['published'] ) ) $this->published = $data['published'];
    //if ( isset( $data['checked_out'] ) ) $this->checked_out = $data['checked_out'];
    //if ( isset( $data['checked_out_time'] ) ) $this->checked_out_time = $data['checked_out_time'];
    if ( isset( $data['editor'] ) ) $this->editor = $data['editor'];
    if ( isset( $data['access'] ) ) $this->access = $data['access'];
    if ( isset( $data['count'] ) ) $this->count = $data['count'];
    if ( isset( $data['params'] ) ) $this->params = $data['params'];
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
  * Returns an Category object matching the given category ID
  *
  * @param int The category ID
  * @return Category|false The category object, or false if the record was not found or there was a problem
  */
  public static function getById( $id ) {
    $st = DB::query("SELECT * FROM jos_categories WHERE id = :id", array(":id" => $id));
    if ($row = $st->fetch())
        return new Category( $row );
    return NULL;
  }

  /**
  * Returns all (or a range of) Category objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the jos_categories (default="parent_id DESC")
  * @return Array|false A two-element array : results => array, a list of Category objects; totalRows => Total number of jos_categories
  */
  public static function getList( $numRows=1000000, $order="ordering, title" ) {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS * FROM jos_categories
            ORDER BY $order LIMIT $numRows");

    $list = array();
    while ( $row = $st->fetch() ) {
      $category = new Category( $row );
      $list[] = $category;
    }

    // Now get the total number of jos_categories that matched the criteria
    $totalRows = DB::fetch("SELECT FOUND_ROWS() AS totalRows");

    return array ( "results" => $list, "totalRows" => $totalRows['totalRows'] );
  }

  /**
  * Inserts the current Category object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the Category object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "Category::insert(): Attempt to insert an Category object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the Category
    $this->id = DB::insert("INSERT INTO jos_categories ( parent_id, title, name, section, description, published, editor, access, count, params, ordering ) VALUES ( :parent_id, :title, :name, :section, :description, :published, :editor, :access, :count, :params, :ordering )", array(
        ":parent_id" => $this->parent_id,
        ":title" => $this->title,
        ":name" => $this->name,
        ":section" => $this->section,
    //	":image" => $this->image,
    //	":image_position" => $this->image_position,
    	":description" => $this->description,
    	":published" => $this->published,
    //	":checked_out" => $this->checked_out,
    //	":checked_out_time" => $this->checked_out_time,
    	":editor" => $this->editor,
    	":access" => $this->access,
    	":count" => $this->count,
		":params" => $this->params,
		":ordering" => $this->ordering,
    ));

    return !empty($this->id);
  }

  /**
  * Updates the current Category object in the database.
  */
  public function update() {
    // Does the Category object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Category::update(): Attempt to update an Category object that does not have its ID property set.", E_USER_ERROR );

    // Update the Category
    $st = DB::query("UPDATE jos_categories SET parent_id=:parent_id, title=:title, name=:name, section=:section, description=:description, published=:published, editor=:editor, access=:access, count=:count, params=:params, ordering=:ordering WHERE id = :id", array(
        ":parent_id" => $this->parent_id,
        ":title" => $this->title,
        ":name" => $this->name,
        ":section" => $this->section,
    //	":image" => $this->image,
    //	":image_position" => $this->image_position,
    	":description" => $this->description,
    	":published" => $this->published,
    //	":checked_out" => $this->checked_out,
    //	":checked_out_time" => $this->checked_out_time,
    	":editor" => $this->editor,
    	":access" => $this->access,
    	":count" => $this->count,
		":params" => $this->params,
		":ordering" => $this->ordering,
        ":id" => $this->id,
      ));

    return $st->rowCount();
  }

  /**
  * Deletes the current Category object from the database.
  */
  public function delete() {
    // Does the Category object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Category::delete(): Attempt to delete an Category object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Category
    DB::query( "DELETE FROM jos_categories WHERE id = :id LIMIT 1", array(":id" => $this->id));
  }
}
