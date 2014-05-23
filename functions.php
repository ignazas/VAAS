<?php

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/helpers/db.inc';

function log_event($user, $event, $param) {	
    $user = DB::escape(isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : $user);
    $event = DB::escape($event);
    $param = DB::escape($param);
    DB::query("INSERT INTO log(user, event, param) VALUES ('$user','$event','$param')");
}
