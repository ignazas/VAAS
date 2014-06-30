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
    $value = /*htmlentities*/(isset($values[$name]) ? $values[$name] : isset($entity->{$name}) ? $entity->{$name} : NULL);
    switch ($type) {
        case 'text':
        case 'url':
        case 'email':
        case 'password':
          $output = '<div';
          if (Messages::has_error($name))
            $output .= ' class="err"';
          $output .= '>';
          if (!empty($label))
            $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
          $output .= '<input class="form-control" type="' . $type . '" id="' . $name . '" name="' . $name . '" value="' . $value . '"/></div>';
          break;
      case 'display_avatar':
        $output = '<div';
        if (Messages::has_error($name))
          $output .= ' class="err"';
        $output .= '>';
        $title = !empty($label) ? $label : NULL;
        if (empty($value))
          $output .= '<img src="/' . CATALOG . '/images/users/avatar.jpg' . '" class="img-thumbnail img-responsive" alt="' . $title . '" title="' . $title . '" />';
        else {
          $img = '/' . CATALOG . '/' . 'uploads/users/' . $value;
          //$output .= '<a href="#" onclick="return false;" rel="popover" data-content="<img src=\'' . $img . '\' alt=\'' . $title . '\' title=\'' . $title . '\' />" data-html="true" data-title="' . $title . '">';
          $output .= '<img src="' . $img . '" class="img-thumbnail img-responsive" alt="' . $title . '" title="' . $title . '" />';
          //$output .= '</a>';
        }
        $output .= '</div>';
        break;
      case 'display':
      case 'display_url':
      case 'display_email':
      case 'display_phone':
      case 'display_password':
      case 'display_percent':
        if (!isset($value) || $value === '')
          break;

        $output = '<div';
        if (Messages::has_error($name))
          $output .= ' class="err"';
        $output .= '>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        switch ($type) {
          case 'display_url':
            $value_short = preg_replace('/^\s*(.*:\/\/|)(www\.|)/', '', $value);
            $output .= '<a style="white-space:nowrap;" href="' . $value . '" target="_blank"><i class="glyphicon glyphicon-link"></i> ' . $value_short . '</a>';
            break;
          case 'display_email':
            $output .= '<a style="white-space:nowrap;" href="mailto:' . $value . '"><i class="glyphicon glyphicon-envelope"></i> ' . $value . '</a>';
            break;
          case 'display_phone':
            $output .= '<a style="white-space:nowrap;" href="tel:' . $value . '"><i class="glyphicon glyphicon-earphone"></i> ' . $value . '</a>';
            break;
          case 'display_password':
            $output .= '<span>' . preg_replace('/[^*]/', '*', $value) . '</span>';
            break;
          case 'display_percent':
            $output .= '<span>' . $value . '%</span>';
            break;
          default:
            $output .= '<span>' . $value . '</span>';
            break;
        }
        $output .= '</div>';
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

function get_day_letter($date) {
  switch(date('w', $date)) {
    case "1":    $savaites_diena = "Pirmadienis";  break;
    case "2":   $savaites_diena = "Antradienis"; break;
    case "3": $savaites_diena = "Trečiadienis";  break;
    case "4":  $savaites_diena = "Ketvirtadienis"; break;
    case "5":    $savaites_diena = "Penktadienis";  break;
    case "6":  $savaites_diena = "Šeštadienis";  break;
    case "0":    $savaites_diena = "Sekmadienis";  break;
    default:          $savaites_diena = "-"; break;
  }
	return mb_substr($savaites_diena, 0, 2);
}
