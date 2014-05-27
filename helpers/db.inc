<?php
require_once dirname(__FILE__) . '/../config.php'; //DB config 

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
        
        if(!$result)
          die(mysql_error());
        return $result;
    }    

    
	public static function fetch_object($query) {
        DB::connect();
		
		$st = DB::$conn->prepare($query);
		
		$st->execute();
		$result = $st->fetchObject();
			
		return $result;
    }    

		
	public static function close() {
        if (DB::$conn != NULL) {
            mysql_close(DB::$conn);
            DB::$conn = NULL;
        }
    }    
	
	
}
