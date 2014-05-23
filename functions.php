<?php

function log_event($user, $event, $param) {	
	$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	IF($_SESSION['user']['username']){$user=$_SESSION['user']['username'];};
    $sql = "INSERT INTO log(user, event, param) VALUES ('$user','$event','$param')";
    $st = $conn->prepare( $sql );
    $st->execute();
	$conn = null;
}


function send_mail($recipient, $title, $content) {
	IF(!$recipient) {$recipient = "magazin@audiounit.lt";};
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .= "From: aeroklubas@sklandymas.lt\r\n";
	$mail = $content . "<br /><br />Išsiųsta iš Vilniaus Aeroklubo narių administravimo sistemos (VAAS)";
	IF(is_array($recipient)) {
		foreach($recipient['email'] as $address){
			mail($address, "VAAS: " . $title , $mail, $headers);
		}
	} ELSE {
		mail($recipient, "VAAS: " . $title , $mail, $headers);
	}
	
	
}
?>