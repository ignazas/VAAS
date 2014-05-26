<?php
class DB {
    private static $conn = NULL;
    
    public static function connect() {
        if (DB::$conn == NULL) {
            DB::$conn = new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
        }
        return DB::$conn;
    }
    
    public static function query($query) {
        DB::connect();
		
		$st = DB::$conn->prepare($query);
		
		$st->execute();
		$result = $st->fetchAll();
		return $result;
    }    
    
    public static function escape($variable) {
        DB::connect();
        return mysql_real_escape_string($variable);
    }
}
