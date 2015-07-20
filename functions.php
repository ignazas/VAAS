<?php

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/helpers/db.inc';
require_once dirname(__FILE__) . '/helpers/date.inc';

function log_event($user, $event, $param) {
    DB::query("INSERT INTO log(user, event, param) VALUES (:user,:event,:param)", array(
        ':user' => isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : $user,
        ':event' => $event,
        ':param' => $param,
    ));
	return;
}

function load_controller($name) {
  $filename = strtolower($name);
  if (file_exists(dirname(__FILE__) . "/controlers/$filename.inc")) {
    require_once dirname(__FILE__) . "/controlers/$filename.inc";
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
    $value = /*htmlentities*/(isset($values[$name]) ? $values[$name] : (isset($entity->{$name}) ? $entity->{$name} : NULL));
    switch ($type) {
        case 'text':
        case 'url':
        case 'email':
        case 'number':
        case 'date':
        case 'password':
          $output = '<div';
          if (Messages::has_error($name))
            $output .= ' class="err"';
          $output .= '>';
          if (!empty($label))
            $output .= '<label class="control-label" for="' . $name . '">' . $label . '</label> ';
          $output .= '<input class="form-control" type="' . $type . '" id="' . $name . '" name="' . $name . '" value="' . $value . '"/></div>';
          break;
        case 'time':
          $output = '<div';
          if (Messages::has_error($name))
            $output .= ' class="err"';
          $output .= '>';
          if (!empty($label))
            $output .= '<label class="control-label" for="' . $name . '">' . $label . '</label> ';
          $output .= '<input class="form-control" type="text" id="' . $name . '" name="' . $name . '" value="' . DateHelper::time_as_string($value) . '"/></div>';
          break;
        case 'checkbox':
          $output = '<div class="checkbox' . (Messages::has_error($name) ? ' err' : NULL) . '">';
          if (!empty($label))
            $output .= '<label class="control-label" for="' . $name . '">' . $label . ' ';
          $output .= '<input type="' . $type . '" id="' . $name . '" name="' . $name . '"' . (empty($value) ? NULL : ' checked="checked"') . '/>';
          if (!empty($label))
            $output .= '</label>';
          $output .= '</div>';
          break;
        case 'decimal':
          $output = '<div';
          if (Messages::has_error($name))
            $output .= ' class="err"';
          $output .= '>';
          if (!empty($label))
            $output .= '<label class="control-label" for="' . $name . '">' . $label . '</label> ';
          $output .= '<input class="form-control" type="number" step="any" pattern="[0-9]+([\,|\.][0-9]+)?" id="' . $name . '" name="' . $name . '" value="' . $value . '"/></div>';
          break;
        case 'textarea':
          $output = '<div';
          if (Messages::has_error($name))
            $output .= ' class="err"';
          $output .= '>';
          if (!empty($label))
            $output .= '<label class="control-label" for="' . $name . '">' . $label . '</label> ';
          $output .= '<textarea class="form-control" id="' . $name . '" name="' . $name . '">' . $value . '</textarea></div>';
          break;
      case 'display_avatar':
        $output = '<div';
        if (Messages::has_error($name))
          $output .= ' class="err"';
        $output .= '>';
        $title = !empty($label) ? $label : NULL;
        if (empty($value))
          $output .= '<img src="' . (defined('CATALOG') && CATALOG ? '/' . CATALOG : NULL) . '/images/users/avatar.jpg' . '" class="img-thumbnail img-responsive" alt="' . $title . '" title="' . $title . '" />';
        else {
          $img = (defined('CATALOG') && CATALOG ? '/' . CATALOG : NULL) . '/' . 'uploads/users/' . $value;
          //$output .= '<a href="#" onclick="return false;" rel="popover" data-content="<img src=\'' . $img . '\' alt=\'' . $title . '\' title=\'' . $title . '\' />" data-html="true" data-title="' . $title . '">';
          $output .= '<img src="' . $img . '" class="img-thumbnail img-responsive" alt="' . $title . '" title="' . $title . '" />';
          //$output .= '</a>';
        }
        $output .= '</div>';
        break;
      case 'display':
        if (!isset($value) || $value === '')
          break;

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<span>' . $value . '</span>';
        $output .= '</div>';
        break;
      case 'display_hhmm':
        if (!isset($value) || $value === '')
          break;

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<span>' . date("H:i", is_numeric($value) ? mktime(0, 0, $value) : strtotime($value)) . '</span>';

        $output .= '</div>';
        break;
      case 'display_time':
        if (!isset($value) || $value === '')
          break;

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<span>' . DateHelper::time_as_string($value) . '</span>';

        $output .= '</div>';
        break;
      case 'display_checkbox':
        if (!isset($value) || $value === '')
          break;

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<span><i class="glyphicon glyphicon-' . (empty($value) ? 'remove' : 'ok') . '"></i></span>';

        $output .= '</div>';
        break;
      case 'display_money':
        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
	$currency_date = (isset($values['date']) ? $values['date'] : (isset($entity->date) ? $entity->date : NULL));
	$currency = (!empty($currency_date) && strtotime($currency_date) < mktime(0, 0, 0, 1, 1, 2015)) ? 'Lt' : '€';
        $output .= '<span>' . (empty($value) ? 0 : $value) . ' ' . $currency . '</span>';
        $output .= '</div>';
        break;
      case 'display_url':
        if (!isset($value) || $value === '')
          break;

        $value_short = preg_replace('/^\s*(.*:\/\/|)(www\.|)/', '', $value);

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<a style="white-space:nowrap;" href="' . $value . '" target="_blank"><i class="glyphicon glyphicon-link"></i> ' . $value_short . '</a>';
        $output .= '</div>';
        break;
      case 'display_email':
        if (!isset($value) || $value === '')
          break;

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<a style="white-space:nowrap;" href="mailto:' . $value . '"><i class="glyphicon glyphicon-envelope"></i> ' . $value . '</a>';
        $output .= '</div>';
        break;
      case 'display_phone':
        if (!isset($value) || $value === '')
          break;

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<a style="white-space:nowrap;" href="tel:' . $value . '"><i class="glyphicon glyphicon-earphone"></i> ' . $value . '</a>';
        $output .= '</div>';
        break;
      case 'display_password':
        if (!isset($value) || $value === '')
          break;

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<span>' . preg_replace('/[^*]/', '*', $value) . '</span>';
        $output .= '</div>';
        break;
      case 'display_percent':
        if (!isset($value) || $value === '')
          break;

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<span>' . $value . '%</span>';
        $output .= '</div>';
        break;
      case 'display_date':
        if (!isset($value) || $value === '')
          break;

        //$value = date('Y-m-d H:i:s', strtotime($value));
        if (!is_string($value))
          $value = date('Y-m-d H:i:s', $value);

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<span>' . $value . '</span>';
        $output .= '</div>';
        break;
      case 'display_date_only':
        if (!isset($value) || $value === '')
          break;

        if (!is_string($value))
          $value = date('Y-m-d', $value);

        $output = '<div>';
        if (!empty($label))
          $output .= '<label for="' . $name . '"><b>' . $label . ':</b></label> ';
        $output .= '<span>' . $value . '</span>';
        $output .= '</div>';
        break;
      default:
        break;
    }

    return $output;
}

function send_mail($recipient, $title, $content) {
  require_once dirname(__FILE__) . '/helpers/messages.inc';

	if (empty($recipient)) {
    Messages::set_message('Pranešimas neišsiųstas - nenurodyti gavėjai');
    return;
  }

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .= "From: aeroklubas@sklandymas.lt\r\n";

	$mail = $content . "<br /><br />Išsiųsta iš Vilniaus Aeroklubo narių administravimo sistemos (VAAS)";
	if (is_array($recipient)) {
    $recipient = array_unique($recipient);
    mail(implode(', ', $recipient), "VAAS: " . $title , $mail, $headers);
    log_event('Admin', 'MultipleMailSent: ' . $title, implode(', ', $recipient));
    Messages::set_message('Pranešimas išsiųstas: ' . implode(', ', $recipient));
	}
  else {
		mail($recipient, "VAAS: " . $title , $mail, $headers);
		log_event('Admin', 'SingleMailSent: ' . $title, $recipient);
    Messages::set_message('Pranešimas išsiųstas: ' . $recipient);
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

function order_link($name=NULL, $url=NULL, $title=NULL) {
  $order = isset($_GET['order']) ? ($_GET['order'] == $name ? 'asc' : 'desc') : NULL;

  $output = NULL;
  if (!empty($url)) {
    $output .= '<a href="' . htmlspecialchars($url . (strpos($url, '?') ? '&' : '?') . 'order=' . urlencode($order != 'desc' ? "-$name" : $name)) . '">';
  }
  if (!empty($title))
    $output .= $title;
  if (!empty($url))
    $output .= ($order == 'asc' ? ' <i class="glyphicon glyphicon-sort-by-alphabet"></i>' : ($order == 'desc' ? ' <i class="glyphicon glyphicon-sort-by-alphabet-alt"></i>' : NULL)) . '</a>';
  return $output;
}
