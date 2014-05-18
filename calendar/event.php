<a class="b-close">[X]<a/>
<?
require_once("includes/config.php");
$db_connection = mysql_connect ($DBHost, $DBUser, $DBPass) OR die (mysql_error());
mysql_set_charset('utf8',$db_connection);
$db_select = mysql_select_db ($DBName) or die (mysql_error());
$db_table = $TBL_PR . "events";

$query = "SELECT * FROM $db_table WHERE event_id='$_GET[id]' LIMIT 1";
$query_result = mysql_query ($query);
while ($info = mysql_fetch_array($query_result)){
    $date =  $info['event_date'];
    $time_array = split(":", $info['event_time']);
    $time = date ("g:ia", mktime($time_array['0'],$time_array['1'],0,$info['event_month'],$info['event_day'],$info['event_year']));
?>

<table >
  <tr>
    <td>
	<table width="480" >
        <tr> 
          <td><span class="eventwhen"><h3><? echo $date . " @ " . $time; ?></h3></span><br></td>
        </tr>
        <tr> 
          <td><span class="event">Dalyvis</span></td>
        </tr>
        <tr> 
          <td><span class="eventdetail"><? echo $info['event_title']; ?></span><br> 
            <br></td>
        </tr>
        <tr> 
          <td><span class="event">Pastabos</span></td>
        </tr>
        <tr> 
          <td><span class="eventdetail"><? echo $info['event_desc']; ?></span><br></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    
  </tr>
</table>

<? } ?>