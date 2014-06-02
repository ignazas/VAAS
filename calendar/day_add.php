<?php 
require_once dirname(__FILE__) . '/../functions.php';

$o = DB::fetch_object("SELECT status FROM days WHERE day = :day LIMIT 1", array(':day' => $_GET['day']));
$current_status = isset($o->status) ? $o->status : 'nevyksta';

$statuses = array(
      "nevyksta"=>'Nevyksta',
      "vyksta"=>'Vyksta',
      "delete"=>'[Šalinti žymą]',
);

session_start();
?>
<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a><br />
<form role="form" action="admin.php">
	
	<select name="status" class="form-control">
<?php foreach ($statuses as $key => $value) { ?>
      <option value="<?php echo $key ?>"<?php if ($current_status == $key) echo ' selected="selected"' ?>><?php echo $value ?></option>
<?php } ?>
	</select><br />
	<input type="text" name="reason" placeholder="Pastaba" class="form-control"/>
	<input type="hidden" name="day" value="<?php echo $_GET['day']; ?>"/>
	<input type="hidden" name="confirmed" value="<?php $_SESSION['user']['name']; ?>"/><br />
	<center><button type="submit" name="action" class="btn btn-primary" value="addDay">Žymėti</button></center>
</form>