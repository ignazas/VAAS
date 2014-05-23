<a class="b-close">[X]<a/><br />
<?
require_once("includes/config.php");
$db_connection = mysql_connect ($DBHost, $DBUser, $DBPass) OR die ("Negaliu prisijungti" . mysql_error());
mysql_set_charset('utf8',$db_connection);
$db_select = mysql_select_db ($DBName) or die (mysql_error());

$day = $_GET['day'];

$a = strptime($day, '%Y-%m-%d');
$timestamp = mktime(0, 0, 0, $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900);
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


$query = "SELECT * FROM calendar_events WHERE event_date='$day' ORDER by event_time";
$result = mysql_query ($query);

echo "<h2>" . $day . ", " . $savaites_diena . "</h2>";
while ($row = mysql_fetch_array($result)){

	$sarasas[] = $row;

};

mysql_free_result($result);
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