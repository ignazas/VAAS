<a class="b-close">[X]<a/>
<?
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/const.inc';

$st = DB::query("SELECT * FROM " . TBL_EVENTS . " WHERE event_id=:id LIMIT 1", array(':id' => $_GET['id']));
while ($info = $st->fetch()){
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