<?php
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/const.inc';

session_start();

if (isset($_POST['submit']))
{
	$_POST['description'] = substr($_POST['description'],0,500);
	$_POST['title'] = substr($_POST['title'],0,30);

	//susikonstruojam menesi
	$menesis = $_POST['month'];
	if($menesis<10) {$menesis = str_pad($menesis, 2, "0", STR_PAD_LEFT);}
	
	//susikonstruojam diena
	$diena = $_POST['day'];
	if($diena<10) {$diena = str_pad($diena, 2, "0", STR_PAD_LEFT);}
	
	$event_date = $_POST['year']."-".$menesis."-".$diena;
	$event_time = $_POST['hour'] . ":" . $_POST['minute'];

	$BookingId = DB::insert('INSERT INTO ' . TBL_EVENTS . ' ( `event_date`, `event_day` , `event_month` , `event_year` , `event_time` , `event_title` , `event_desc`, `user_id` ) VALUES (:event_date, :day, :month, :year, :time, :title, :description, :user_id)', array(
    	':event_date' => $event_date,
	    ':day' => isset($_POST['day']) ? $_POST['day'] : date('j'),
        ':month' => isset($_POST['month']) ? $_POST['month'] : date('n'),
        ':year' => isset($_POST['year']) ? $_POST['year'] : date('y'),
        ':time' => (isset($_POST['hour']) ? $_POST['hour'] : 10).':'.(isset($_POST['minute']) ? $_POST['minute'] : 0),
        ':title' => isset($_POST['title']) ? $_POST['title'] : '',
        ':description' => isset($_POST['description']) ? $_POST['description'] : '',
        ':user_id' => isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL));
	$_POST['month'] = $_POST['month'] + 1;
	$pranesimas = "Jūs užsiregistravote skrydžiams " . $event_date . " dieną, " . $event_time . " valandą.<br />Jūsų pastaba: " . $_POST['description'];
	$meilas = $_SESSION['user']['email'];
	$user = $_SESSION['user']['username'];
	send_mail($meilas,"Jūsų registracija skrydžiams",$pranesimas);
		
	//redirect
	header( "Location: ../index.php?action=calendar&year=" . $_POST['year'] . "&month=" . $_POST['month'] ) ;
}
else 
{
	
	$menesis = $_GET['month'];
	if($menesis<10) {$menesis = str_pad($menesis, 2, "0", STR_PAD_LEFT);}
	
	//susikonstruojam diena
	$diena = $_GET['day'];
	if($diena<10) {$diena = str_pad($diena, 2, "0", STR_PAD_LEFT);}
	
	$event_date = $_GET['year']."-".$menesis."-".$diena;
	$weekday = date('w', mktime(0, 0, 0, $_GET['month'], $_GET['day'], $_GET['year']));
?>

<a class="b-close">[X]<a/>
<form name="form1" method="post" action="calendar/event_add.php" class="calendar">
  <table border="0" cellspacing="0" cellpadding="0">
  	
    <tr> 
      <td width="200" height="40" valign="top"><span class="addevent">Atvykimo diena:</span><br> 
        <td height="40" valign="top">
  			<?php echo $event_date; ?>
        </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top"><span class="addevent">Atvykimo laikas:</span><br> 
        <span class="addeventextrainfo">(24val formatas)</span></td>
      <td height="40" valign="top">
      	<input class="form-control" style="width: 50px; display: inline" name="hour" type="text" id="hour" value="<?php echo $weekday == 0 || $weekday == 6 ? 10 : 16 ?>" size="2" maxlength="2"> :
      	<input class="form-control" style="width: 50px;display: inline" name="minute" type="text" id="minute" value="00" size="2" maxlength="2"><br />
      </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top"><span class="addevent">Registracijos pastabos</span><br>
      	<span class="addeventextrainfo">Nurodykite, jei reikalinga nakvynė, skrydžiai į aikštelę ar pan.</span>
      	<span class="addeventextrainfo">Nurodykite kiek ir kokius skrydžius planuojate, esate instruktorius ar autoišvilktuvo operatorius.</span>
      	</td>
      <td height="40" valign="top"> <textarea class="form-control" name="description" cols="18" rows="5" id="description"></textarea> 
      </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><br /><input class="btn btn-primary" name="submit" type="submit" id="submit" value="Registruotis"></td>
    </tr>
  </table>
  <input name="title" type="hidden" value="<?php echo $_SESSION['user']['name']; ?>">
  <input name="year" type="hidden" value="<?php echo $_GET['year']; ?>">
  <input name="month" type="hidden" value="<?php echo $_GET['month']; ?>">
  <input name="day" type="hidden" value="<?php echo $_GET['day']; ?>">
</form>
<?php 
} 
 ?>