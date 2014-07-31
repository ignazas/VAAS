<?php
require_once dirname(__FILE__) . '/../config.php';
//DB config

class DB {
    private static $conn = NULL;

    public static function connect() {
        if (DB::$conn == NULL) {
          try {
            DB::$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
          } catch(PDOException $ex) {
            die("Failed to connect to the database: " . $ex->getMessage());
          }
          DB::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          DB::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return DB::$conn;
    }

    public static function query($query, $params = NULL) {
        DB::connect();

        $st = DB::$conn->prepare($query);
        if (!$st)
            die(DB::$conn->errorInfo());

	try {
    $st->execute($params);
	} catch (Exception $ex) {
	    die($ex);
	}

        return $st;
    }

    public static function fetch_object($query, $params = NULL) {
	$st = DB::query($query, $params);
        return $st->fetchObject();
    }

    public static function fetch($query, $params = NULL) {
	$st = DB::query($query, $params);
        return $st->fetch();
    }

    public static function insert($query, $params = NULL) {
        $st = DB::query($query, $params);
        return DB::$conn->lastInsertId();
    }

    public static function escape($string) {
        DB::connect();

        return DB::$conn->quote($string);
    }

    public static function close() {
        if (DB::$conn != NULL) {
            DB::$conn = NULL;
        }
    }

    public static function null_if_empty($value) {
      return empty($value) ? PDO::PARAM_NULL : $value;
    }

    public static function date_as_string($value) {
      return empty($value) ? 'NULL' : ("'" . (is_string($value) ? "$value" : date('Y-m-d H:i:s', $value)). "'");
    }
}
