<?php
require_once dirname(__FILE__) . '/../functions.php';

session_start();

if (isset($_POST['submit'])) {
  $_POST['description'] = !empty($_POST['description']) ? substr(trim($_POST['description']),0,500) : '';
	$title = $_POST['title'] = !empty($_POST['title']) ? substr(trim($_POST['title']),0,30) : '';

	//susikonstruojam menesi
	$menesis = $_POST['month'];
	if($menesis<10) {$menesis = str_pad($menesis, 2, "0", STR_PAD_LEFT);}

	//susikonstruojam diena
	$diena = $_POST['day'];
	if($diena<10) {$diena = str_pad($diena, 2, "0", STR_PAD_LEFT);}

	$event_date = $_POST['year']."-".$menesis."-".$diena;
	$event_time = isset($_POST['time']) ? str_replace(array('.', ','), ':', $_POST['time']) : '10:00';

	$BookingId = DB::insert('INSERT INTO `calendar_events` ( `event_date`, `event_day` , `event_month` , `event_year` , `event_time` , `event_title` , `event_desc`, `user_id` ) VALUES (:event_date, :day, :month, :year, :time, :title, :description, :user_id)', array(
    	':event_date' => $event_date,
	    ':day' => isset($_POST['day']) ? $_POST['day'] : date('j'),
        ':month' => isset($_POST['month']) ? $_POST['month'] : date('n'),
        ':year' => isset($_POST['year']) ? $_POST['year'] : date('y'),
        ':time' => $event_time,
        ':title' => $title,
        ':description' => isset($_POST['description']) ? $_POST['description'] : '',
        ':user_id' => isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL));
	$_POST['month'] = $_POST['month'] + 1;
	$pranesimas =
	    "Jūs užsiregistravote skrydžiams " . $event_date . " dieną, " . $event_time . " valandą." .
	    (!empty($_POST['description']) ? ("<br />Jūsų pastaba: " . $_POST['description']) : NULL);
	$meilas = $_SESSION['user']['email'];
	$user = $_SESSION['user']['username'];

  require_once dirname(__FILE__) . '/../helpers/messages.inc';
	Messages::set_message($pranesimas);

	//redirect
	$destination = !empty($_GET['destination']) ? $_GET['destination'] : ("../index.php?action=calendar&year=" . $_POST['year'] . "&month=" . $_POST['month']);
	header("Location: $destination") ;
}
else {
	$menesis = $_GET['month'];
	if($menesis<10) {$menesis = str_pad($menesis, 2, "0", STR_PAD_LEFT);}

	//susikonstruojam diena
	$diena = $_GET['day'];
	if($diena<10) {$diena = str_pad($diena, 2, "0", STR_PAD_LEFT);}

	$event_date = $_GET['year']."-".$menesis."-".$diena;
	$weekday = date('w', mktime(0, 0, 0, $_GET['month'], $_GET['day'], $_GET['year']));
?>

<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a>

<h2 class="eventwhen col-xs-12">Įvykio registravimas</h2>

<form name="form1" method="post" action="calendar/event_add.php<?php echo !empty($_GET['destination']) ? "?destination=$_GET[destination]" : NULL ?>" class="calendar col-xs-12 form-horizontal" role="form">
  <div class="form-group">
    <label class="col-sm-3 control-label">Atvykimo diena</label>
    <div class="col-sm-9">
      <p class="form-control-static"><?php echo $event_date ?></p>
    </div>
  </div>
  <div class="form-group">
    <label for="time" class="col-sm-3 control-label">Atvykimo laikas</label>
    <div class="col-sm-9">
      <input type="time" class="form-control" name="time" id="time" value="<?php echo !empty($_POST['time']) ? $_POST['time'] : ($weekday == 0 || $weekday == 6 ? '10:00' : '16:00') ?>">
      <!-- <p class="help-block">24 val formatas</p> -->
    </div>
  </div>
<?php if ($_SESSION['user']['usertype']=="Administrator" || $_SESSION['user']['usertype']=="Super Administrator") { ?>
  <div class="form-group">
    <label for="title" class="col-sm-3 control-label">Įvykis</label>
    <div class="col-sm-9">
      <select class="form-control" name="title" id="title">
	<option selected="selected" value="<?php echo $_SESSION['user']['name']; ?>">Registracija skrydžiams</option>
	<option value="talka">Visuotinė talka</option>
	<option value="šventė">Klubo šventė</option>
	<option value="svečiai">Svečiai</option>
	<option value="kita">Kita</option>
      </select>
    </div>
  </div>
<?php } else { ?>
  <input name="title" type="hidden" value="<?php echo $_SESSION['user']['name'] ?>">
<?php } ?>
  <div class="form-group">
    <label for="description" class="col-sm-3 control-label">Registracijos pastabos</label>
    <div class="col-sm-9">
      <textarea class="form-control" rows="5" name="description" id="description"><?php echo !empty($_POST['description']) ? $_POST['description'] : '' ?></textarea>
      <p class="help-block">Nurodykite, jei reikalinga nakvynė, skrydžiai į aikštelę ar pan.</p>
      <p class="help-block">Nurodykite kiek ir kokius skrydžius planuojate, esate instruktorius ar autoišvilktuvo operatorius.</p>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      <button type="submit" name="submit" id="submit" class="btn btn-primary">Registruotis</button>
    </div>
  </div>

  <input name="year" type="hidden" value="<?php echo $_GET['year']; ?>">
  <input name="month" type="hidden" value="<?php echo $_GET['month']; ?>">
  <input name="day" type="hidden" value="<?php echo $_GET['day']; ?>">
</form>
<?php } ?>
