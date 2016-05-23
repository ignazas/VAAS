<?php
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/../helpers/user.inc';

UserHelper::check_access(FALSE);

$o = DB::fetch_object("SELECT status, reason FROM days WHERE day = :day AND :status IS NOT NULL AND status=:status LIMIT 1", array(':day' => $_GET['day'], ':status' => empty($_GET['status']) ? NULL : $_GET['status']));
$current_status = isset($o->status) ? $o->status : 'nevyksta';

$statuses = array(
      "nevyksta"=>'Nevyksta',
      "vyksta"=>'Vyksta',
);
?>

<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a>

<h2 class="eventwhen col-xs-12">Žyma</h2>

<form class="col-xs-12 form-horizontal" role="form" action="admin.php" method="get">
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
      <textarea class="form-control" rows="3" name="reason" id="reason"><?php echo !empty($_POST['reason']) ? $_POST['reason'] : !empty($o->reason) ? $o->reason : NULL ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="reason" class="col-sm-3 control-label">Siųsti pranešimą</label>
    <div class="col-sm-9">
      <div class="radio">
	<label>
	  <input type="radio" name="mail" id="none" value="none" checked="checked">
	  Nesiųsti niekam
	</label>
      </div>
      <div class="radio">
	<label>
	  <input type="radio" name="mail" id="all" value="all">
	  Visiems
	</label>
      </div>
      <div class="radio">
	<label>
	  <input type="radio" name="mail" id="flying" value="flying">
	  Užsiregistravusiems skrydžiui
	</label>
      </div>
      <div class="radio">
	<label>
	  <input type="radio" name="mail" id="me" value="me">
	  Man
	</label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      <button type="submit" name="action" id="action" class="btn btn-primary" value="addDay">Žymėti</button>
      <button type="submit" name="action" id="action" class="btn btn-primary btn-danger" value="deleteDay">Naikinti</button>
    </div>
  </div>

  <input type="hidden" name="day" value="<?php echo $_GET['day']; ?>"/>
  <input type="hidden" name="confirmed" value="<?php echo $_SESSION['user']['name']; ?>"/>
  <input type="hidden" name="destination" value="<?php echo $_SERVER['HTTP_REFERER'] ?>"/>
</form>
