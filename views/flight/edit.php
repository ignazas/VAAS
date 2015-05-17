<?php
require_once dirname(__FILE__) . '/../../models/service.inc';
$services = Service::getList();
require_once dirname(__FILE__) . '/../../models/user.inc';
$users = User::getList();
$instructors = User::getList(1000000, 'u.name', '`instructor`=1');
require_once dirname(__FILE__) . '/../../models/aircraft.inc';
$airplanes = Aircraft::getList();
?>

<form id="flight-edit" class="form-horizontal" action="" method="POST" role="form">
  <input type="hidden" name="id" value="<?php echo $results['flight']->record_id ?>" />
  <fieldset>
    <legend>Redaguoti skrydį</legend>

    <div class="form-group">
      <?php echo theme('date', 'date', 'Data', $results['flight'], $_POST) ?>
    </div>

    <div class="form-group">
      <label class="control-label" for="service_id">Paslauga</label>
      <select name="service_id" id="service_id" class="form-control">
	<option value=""></option>
<?php foreach ($services['results'] as $service) { ?>
	<option amount="<?php echo $service->amount ?>" discount_disabled="<?php echo $service->discount_disabled ?>" value="<?php echo $service->id ?>"<?php echo (!empty($_POST['service_id']) && $_POST['service_id'] == $service->id) || (!empty($results['flight']->service_id) && $results['flight']->service_id == $service->id) ? ' selected="selected"' : NULL ?>><?php echo $service->title ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label class="control-label" for="payer">Mokinys/Pirkėjas</label>
      <select name="payer" id="payer" class="form-control">
	<option value=""></option>
<?php foreach ($users['results'] as $user) { ?>
	<option discount="<?php echo $user->discount ?>" value="<?php echo $user->id ?>"<?php echo (!empty($_POST['payer']) && $_POST['payer'] == $user->id) || (!empty($results['flight']->payer) && $results['flight']->payer == $user->id) ? ' selected="selected"' : NULL ?>><?php echo $user->name ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label class="control-label" for="instructor">Instruktorius</label>
      <select name="instructor" id="instructor" class="form-control">
	<option value=""></option>
<?php foreach ($instructors['results'] as $user) { ?>
	<option value="<?php echo $user->id ?>"<?php echo (!empty($_POST['instructor']) && $_POST['instructor'] == $user->id) || (!empty($results['flight']->instructor) && $results['flight']->instructor == $user->id) ? ' selected="selected"' : NULL ?>><?php echo $user->name ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label class="control-label" for="airplane_id">Orlaivis</label>
      <select name="airplane_id" id="airplane_id" class="form-control">
	<option value=""></option>
<?php foreach ($airplanes['results'] as $airplane) { ?>
	<option value="<?php echo $airplane->id ?>"<?php echo (!empty($_POST['airplane_id']) && $_POST['airplane_id'] == $airplane->id) || (!empty($results['flight']->airplane_id) && $results['flight']->airplane_id == $airplane->id) ? ' selected="selected"' : NULL ?>><?php echo $airplane->name ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <?php echo theme('number', 'amount', 'Kiekis', $results['flight'], $_POST) ?>
    </div>

    <div class="form-group">
      <?php echo theme('number', 'price', 'Kaina', $results['flight'], $_POST) ?>
    </div>

    <div class="buttons">
      <input type="submit" class="btn btn-sm btn-primary" name="saveChanges" value="Saugoti" />
      <a href="index.php?action=flight" class="btn btn-sm">Atšaukti</a>
    </div>

  </fieldset>
</form>
