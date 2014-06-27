<?php
require_once dirname(__FILE__) . '/../config.php';
//DB config

class DB {
    private static $conn = NULL;

    public static function connect() {
        if (DB::$conn == NULL) {
            DB::$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        }
        return DB::$conn;
    }

    public static function query($query, $params = NULL) {
        DB::connect();

        $st = DB::$conn->prepare($query);
        if (!$st)
            die(DB::$conn->errorInfo());

        if (!$st->execute($params)) {
	    print_r($params);
	    die("Error in sql query: $query");
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

}
