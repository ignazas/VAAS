<?php
require_once dirname(__FILE__) . '/../helpers/db.inc';

class Service
{

  public $id = null;
  public $date = null;
  public $title = null;
  public $summary = null;
  public $content = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
    if ( isset( $data['date'] ) ) $this->date = (int) $data['date'];
    if ( isset( $data['title'] ) ) $this->title =  $data['title'];
    if ( isset( $data['summary'] ) ) $this->summary = $data['summary'];
    if ( isset( $data['content'] ) ) $this->content = $data['content'];
  }

  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */
  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );

    // Parse and store the publication date
    if ( isset($params['date']) ) {
      $date = explode ( '-', $params['date'] );

      if ( count($date) == 3 ) {
        list ( $y, $m, $d ) = $date;
        $this->date = mktime ( 0, 0, 0, $m, $d, $y );
      }
    }
  }

  /**
  * Returns an Article object matching the given article ID
  *
  * @param int The article ID
  * @return Article|false The article object, or false if the record was not found or there was a problem
  */
  public static function getById( $id ) {
    $st = DB::query("SELECT *, UNIX_TIMESTAMP(date) AS date FROM articles WHERE id = :id", array(":id" => $id));
    if ($row = $st->fetch())
        return new Article( $row );
    return NULL;
  }

  /**
  * Returns all (or a range of) Article objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="date DESC")
  * @return Array|false A two-element array : results => array, a list of Article objects; totalRows => Total number of articles
  */
  public static function getList( $numRows=1000000, $order="date DESC" ) {
    $st = DB::query("SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(date) AS date FROM articles
            ORDER BY $order LIMIT $numRows");

    $list = array();
    while ( $row = $st->fetch() ) {
      $article = new Article( $row );
      $list[] = $article;
    }

    // Now get the total number of articles that matched the criteria
    $st = DB::query("SELECT FOUND_ROWS() AS totalRows");
    $totalRows = $st->fetch();

    return array ( "results" => $list, "totalRows" => $totalRows[0] );
  }

  /**
  * Inserts the current Article object into the database, and sets its ID property.
  */
  public function insert() {
    // Does the Article object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "Article::insert(): Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the Article
    $this->id = DB::insert("INSERT INTO articles ( date, title, summary, content ) VALUES ( FROM_UNIXTIME(:date), :title, :summary, :content )", array(
        ":date" => $this->date,
        ":title" => $this->title,
        ":summary" => $this->summary,
        ":content" => $this->content,
    ));

    send_mail("", $this->title, $this->content);

    return !empty($this->id);
  }

  /**
  * Updates the current Article object in the database.
  */
  public function update() {
    // Does the Article object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );

    // Update the Article
    $st = DB::query("UPDATE articles SET date=FROM_UNIXTIME(:date), title=:title, summary=:summary, content=:content WHERE id = :id", array(
        ":date" => $this->date,
        ":title" => $this->title,
        ":summary" => $this->summary,
        ":content" => $this->content,
        ":id" => $this->id,
      ));

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: aeroklubas@sklandymas.lt\r\n";
    $mail = "Sveiki,<br />Buvo paskelbtas atnaujintas senas VAK pranešimas: <br /><br />";
    $mail .= $this->content . "<br /><br />Išsiųsta iš Vilniaus Aeroklubo narių administravimo sistemos";
    mail("ignas@igfe.eu", $this->title, $mail, $headers);

    return $st->rowCount();
  }

  /**
  * Deletes the current Article object from the database.
  */
  public function delete() {
    // Does the Article object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Article
    DB::query( "DELETE FROM articles WHERE id = :id LIMIT 1", array(":id" => $this->id));
  }
}
