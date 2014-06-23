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

<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a>

<h2 class="eventwhen col-xs-12">Žyma</h2>

<form class="col-xs-12 form-horizontal" role="form" action="admin.php">
  <div class="form-group">
    <label for="status" class="col-sm-3 control-label">Būsena</label>
    <div class="col-sm-9">
	<select name="status" id="status" class="form-control">
<?php foreach ($statuses as $key => $value) { ?>
          <option value="<?php echo $key ?>"<?php if ($current_status == $key) echo ' selected="selected"' ?>><?php echo $value ?></option>
<?php } ?>
	</select>
    </div>
  </div>
  <div class="form-group">
    <label for="reason" class="col-sm-3 control-label">Pastaba</label>
    <div class="col-sm-9">
      <textarea class="form-control" rows="3" name="reason" id="reason">
	<?php echo !empty($_POST['reason']) ? $_POST['reason'] : '' ?>
      </textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      <button type="submit" name="action" id="action" class="btn btn-primary">Žymėti</button>
    </div>
  </div>

  <input type="hidden" name="day" value="<?php echo $_GET['day']; ?>"/>
  <input type="hidden" name="confirmed" value="<?php $_SESSION['user']['name']; ?>"/>
</form>
