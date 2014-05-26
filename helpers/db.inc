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
        return mysql_query($query) /*|| die(mysql_error())*/;
    }    
    
    public static function escape($variable) {
        DB::connect();
        return mysql_real_escape_string($variable);
    }
}
