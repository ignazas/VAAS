<?php

function log_event($user, $event, $param) {	
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	IF($_SESSION['user']['username']){$user=$_SESSION['user']['username'];};
    $sql = "INSERT INTO log(user, event, param) VALUES ('$user','$event','$param')";
    $st = $conn->prepare( $sql );
    $st->execute();
	$conn = null;
}

?>