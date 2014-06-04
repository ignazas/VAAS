<?php

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/helpers/db.inc';

function log_event($user, $event, $param) {
    DB::query("INSERT INTO log(user, event, param) VALUES (:user,:event,:param)", array(
        ':user' => isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : $user,
        ':event' => $event,
        ':param' => $param,
    ));
	return;
}

function load_controller($name) {
    if (file_exists(dirname(__FILE__) . "/controlers/$name.inc")) {
        require_once dirname(__FILE__) . "/controlers/$name.inc";
        if ($class = new ReflectionClass(ucwords($name).'Controler')) {
            if(session_id() == '') session_start();
            return $class->newInstanceArgs();
        }
    }
    return FALSE;
}

function theme($type, $name, $label, $entity, $values=NULL) {
    require_once dirname(__FILE__) . '/helpers/messages.inc';

    $output = NULL;

    switch ($type) {
        case 'text':
        case 'url':
        case 'email':
        case 'password':
            $output = '<div';
            if (Messages::has_error('name'))
                $output .= ' class="err"';
            $output .= '>';
	    if (!empty($label))
		$output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
	    $output .= '<input class="form-control" type="' . $type . '" id="' . $name . '" name="' . $name . '" value="' . /*htmlentities*/(isset($values[$name]) ? $values[$name] : isset($entity->{$name}) ? $entity->{$name} : NULL) . '"/></div>';
            break;
        case 'display':
            $output = '<div';
            if (Messages::has_error('name'))
                $output .= ' class="err"';
            $output .= '>';
	    if (!empty($label))
		$output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
	    $output .= '<span>' . /*htmlentities*/(isset($values[$name]) ? $values[$name] : isset($entity->{$name}) ? $entity->{$name} : NULL) . '</span></div>';
            break;
        default:
            break;
    }

    return $output;
}

function send_mail($recipient, $title, $content) {
	IF(!$recipient) {$recipient = "magazin@audiounit.lt";};
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .= "From: aeroklubas@sklandymas.lt\r\n";
	$mail = $content . "<br /><br />Išsiųsta iš Vilniaus Aeroklubo narių administravimo sistemos (VAAS)";
	IF(is_array($recipient)) {
		foreach($recipient as $address){
			//mail($address['email'], "VAAS: " . $title , $mail, $headers);
			log_event('Admin', 'MultipleMailSent: ' . $title, $address);
		}
	} ELSE {
		//mail($recipient, "VAAS: " . $title , $mail, $headers);
		log_event('Admin', 'SingleMailSent: ' . $title, $recipient);
	}
}