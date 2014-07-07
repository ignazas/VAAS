<?php
require_once dirname(__FILE__) . '/../functions.php';

$day = $_GET['day'];

$a = strftime($day, strtotime('%Y-%m-%d'));

$susprogus_data = explode("-",$a);
$timestamp = mktime(0, 0, 0, $susprogus_data[1], $susprogus_data[2], $susprogus_data[0]);
$savaites_diena = date('l', $timestamp);

switch($savaites_diena)
{
	case "Monday":    $savaites_diena = "Pirmadienis";  break;
	case "Tuesday":   $savaites_diena = "Antradienis"; break;
	case "Wednesday": $savaites_diena = "Trečiadienis";  break;
	case "Thursday":  $savaites_diena = "Ketvirtadienis"; break;
	case "Friday":    $savaites_diena = "Penktadienis";  break;
	case "Saturday":  $savaites_diena = "Šeštadienis";  break;
	case "Sunday":    $savaites_diena = "Sekmadienis";  break;
	default:          $savaites_diena = "-"; break;
}

require_once dirname(__FILE__) . '/../models/calendar_event.inc';
$result = CalendarEvent::getByDate($day);
?>

<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a>

<h2 class="eventwhen col-xs-12"><?php echo $day . ", " . $savaites_diena ?></h2>

<div class="col-xs-12">
<table style="width:600px;" class="table table-striped">
        <tr>
          <th class="col-lg-2 col-xs-1 hidden-xs hidden-sm"></th>
          <th class="col-xs-2">Laikas</th>
          <th class="col-xs-4">Vardas</th>
          <th>Pastaba</th>
        </tr>

<?php foreach ($result['results'] as $event) { ?>
        <tr>
	  <td class="col-lg-2 col-xs-1 hidden-xs hidden-sm"><?php echo theme('display_avatar', 'avatar', $event->user->name, $event->user) ?></td>
	  <td class="col-xs-2"><?php echo theme('display', 'event_time', NULL, $event) ?></td>
	  <td class="col-xs-4">
	    <?php echo theme('display', 'event_title', NULL, $event) ?>
	    <?php if ($event->event_title != $event->user->name) echo theme('display', 'name', NULL, $event->user) ?>
	    <?php echo theme('display_phone', 'telephone1', NULL, $event->user) ?>
	    <?php echo theme('display_email', 'email', NULL, $event->user) ?>
	  </td>
	  <td><?php echo theme('display', 'event_desc', NULL, $event) ?></td>
        </tr>
<?php } ?>

</table>
</div>
