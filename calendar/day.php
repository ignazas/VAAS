<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a>
<?php
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/const.inc';

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

<h2><?php echo $day . ", " . $savaites_diena ?></h2>

<div style="display: block">
<table style="width: 600px; "  class="table table-striped">
        <tr> 
          <th class="col-xs-1"></th>
          <th class="col-xs-2">Laikas</th>
          <th class="col-xs-4">Vardas</th>
          <th>Pastaba</th>
        </tr>

<?php foreach ($result['results'] as $event) { ?>
        <tr>
	  <td class="col-xs-1"><img src="<?php echo '/' . CATALOG . '/' . (empty($event->user->avatar) ? 'images/users/avatar.jpg' : ('uploads/users/' . $event->user->avatar)) ?>" class="img-thumbnail img-responsive" alt="<?php echo htmlentities($event->user->name) ?>"></td>
	  <td class="col-xs-1"><?php echo theme('display', 'event_time', NULL, $event) ?></td>
	  <td class="col-xs-4"><?php echo theme('display', 'event_title', NULL, $event) ?></td>
	  <td><?php echo theme('display', 'event_desc', NULL, $event) ?></td>
        </tr>
<?php } ?>

</table>
</div>
</body>
</html>
