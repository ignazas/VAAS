<?php
class DB {
    private static $conn = NULL;
    
    public static function connect() {
        if (DB::$conn == NULL) {
            DB::$conn = mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD) or die(mysqli_connect_errno($con));
            mysql_select_db(DB_DATABASE, DB::$conn) or die (mysql_error());
            mysql_query("SET CHARACTER SET utf8");
        }
        return DB::$conn;
    }
    
    public static function query($query) {
        DB::connect();
        $result = mysql_query($query);
        if(!$result)
          die(mysql_error());
        return $result;
    }    

    public static function fetch_object($query) {
        DB::connect();
        if ($result = DB::query($query))
            return mysql_fetch_object($result);
    }    
    
    public static function escape($variable) {
        DB::connect();
        return mysql_real_escape_string($variable);
    }
    
    public static function close() {
        if (DB::$conn != NULL) {
            mysql_close(DB::$conn);
            DB::$conn = NULL;
        }
    }    
}
