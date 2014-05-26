<?php

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/helpers/db.inc';

function log_event($user, $event, $param) {	
    $user = DB::escape(isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : $user);
    $event = DB::escape($event);
    $param = DB::escape($param);
    DB::query("INSERT INTO log(user, event, param) VALUES ('$user','$event','$param')");
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