<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a><br />
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


$result = DB::query("SELECT * FROM calendar_events WHERE event_date=:day ORDER by event_time", array(':day' => $day));

echo "<h2>" . $day . ", " . $savaites_diena . "</h2>";

$sarasas = array();
foreach ($result as $row){
	$sarasas[] = $row;
};

?>
<div style="display: block">
<table style="width: 600px; "  class="table table-striped">
        <tr> 
          <th>Laikas</th>
          <th>Vardas</th>
          <th>Pastaba</th>
        </tr>

			<?php foreach ( $sarasas as $irasas ) { 
				echo "<td>".$irasas['event_time']."</td>";
				echo "<td>".$irasas['event_title']."</td>";
				echo "<td>".$irasas['event_desc']."</td>";
          		echo "</tr>";
		  }?>

</table>
</div>
</body>
</html>