
<?
require_once("includes/config.php");

session_start();

$db_connection = mysql_connect ($DBHost, $DBUser, $DBPass) OR die (mysql_error());  
$db_select = mysql_select_db ($DBName) or die (mysql_error());
mysql_set_charset('utf8',$db_connection);

IF(isset($_POST['submit']))
{
	$db_table = $TBL_PR . "events";
	
	$_POST['description'] = substr($_POST['description'],0,500);
	$_POST['title'] = substr($_POST['title'],0,30);

	//susikonstruojam menesi
	$menesis = $_POST['month'];
	if($menesis<10) {$menesis = str_pad($menesis, 2, "0", STR_PAD_LEFT);}
	
	//susikonstruojam diena
	$diena = $_POST['day'];
	if($diena<10) {$diena = str_pad($diena, 2, "0", STR_PAD_LEFT);}
	
	$event_date = $_POST['year']."-".$menesis."-".$diena;


	$id = mysql_query("INSERT INTO $db_table ( `event_id` , `event_date`, `event_day` , `event_month` , `event_year` , `event_time` , `event_title` , `event_desc`, `user_id` ) VALUES ('', '".addslashes($event_date)."', '".addslashes($_POST['day'])."', '".addslashes($_POST['month'])."', '".addslashes($_POST['year'])."', '".addslashes($_POST['hour'].":".$_POST['minute'])."', '".addslashes($_POST['title'])."', '".addslashes($_POST['description'])."', '".addslashes($_SESSION['user']['id'])."')");
	$_POST['month'] = $_POST['month'] + 1;
	
	//log it
    mysql_query("INSERT INTO log (`user`, `event`, `param`) VALUES ('".$_SESSION['user']['username']."','Registers','".mysql_insert_id()."')");

	//redirect
	header( 'Location: ../index.php?action=calendar' ) ;
}
ELSE 
{
	
	$menesis = $_GET['month'];
	if($menesis<10) {$menesis = str_pad($menesis, 2, "0", STR_PAD_LEFT);}
	
	//susikonstruojam diena
	$diena = $_GET['day'];
	if($diena<10) {$diena = str_pad($diena, 2, "0", STR_PAD_LEFT);}
	
	$event_date = $_GET['year']."-".$menesis."-".$diena;
?>

<a class="b-close">[X]<a/>
<form name="form1" method="post" action="calendar/event_add.php">
  <table width="500" border="0" cellspacing="0" cellpadding="0">
  	
    <tr> 
      <td width="200" height="40" valign="top"><span class="addevent">Atvykimo diena:</span><br> 
        <td height="40" valign="top">
  			<? echo $event_date; ?>
        </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top"><span class="addevent">Atvykimo laikas:</span><br> 
        <span class="addeventextrainfo">(24val formatas)</span></td>
      <td height="40" valign="top">
      	<input class="form-control" style="width: 50px; display: inline" name="hour" type="text" id="hour" value="10" size="2" maxlength="2"> : 
      	<input class="form-control" style="width: 50px;display: inline" name="minute" type="text" id="minute" value="00" size="2" maxlength="2"><br />
      </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top"><span class="addevent">Registracijos pastabos</span><br>
      	<span class="addeventextrainfo">Nurodykite, jei reikalinga nakvynė, skrydžiai į aikštelę ar pan.</span>
      	<span class="addeventextrainfo">Nurodykite kiek ir kokius skrydžius planuojate ar esate instruktorius ar autoišvilktuvo operatorius.</span>
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
  <input name="year" type="hidden" value="<? echo $_GET['year']; ?>">
  <input name="month" type="hidden" value="<? echo $_GET['month']; ?>">
  <input name="day" type="hidden" value="<? echo $_GET['day']; ?>">
</form>
<? 
} 
?>