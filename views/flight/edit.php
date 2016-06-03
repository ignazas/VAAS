<?php
$isOwner = $results['flight']->payer == UserHelper::get_id();
$currentService = NULL;
foreach ($services['results'] as $service)
    if ($results['flight']->service_id == $service->id) $currentService = $service;
?>
         

<form id="flight-edit" class="form-horizontal" action="" method="POST" role="form">
  <input type="hidden" name="id" value="<?php echo $results['flight']->record_id ?>" />
  <input type="hidden" name="destination" value="<?php echo $this->Referrer() ?>" />
  <fieldset>
    <legend>Redaguoti skrydį</legend>

    <div class="form-group">
      <?php echo theme('date', 'date', 'Data', $results['flight'], $_POST) ?>
    </div>

    <div class="form-group">
      <label class="control-label" for="service">Skrydis</label>
      <select name="service_id" disabled="disabled" id="service" class="form-control service"<?php if (!$this->HasPermission('Flight Manager')) echo ' disabled="disabled"'; ?>>
	<option value=""></option>
<?php foreach ($services['results'] as $service) { ?>
	<option amount="<?php echo $service->amount ?>" is_discount="<?php echo $service->is_discount ?>" value="<?php echo $service->id ?>"<?php echo (!empty($_POST['service_id']) && $_POST['service_id'] == $service->id) || (!empty($results['flight']->service_id) && $results['flight']->service_id == $service->id) ? ' selected="selected"' : NULL ?>><?php echo $service->title ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label class="control-label" for="payer">Pilotas</label>
      <select name="payer" id="payer" class="form-control user"<?php if (!$this->HasPermission('Flight Manager')) echo ' disabled="disabled"'; ?>>
	<option value=""></option>
<?php foreach ($users['results'] as $user) { ?>
	<option discount="<?php echo $user->discount ?>" value="<?php echo $user->id ?>"<?php echo (!empty($_POST['payer']) && $_POST['payer'] == $user->id) || (!empty($results['flight']->payer) && $results['flight']->payer == $user->id) ? ' selected="selected"' : NULL ?>><?php echo $user->name ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label class="control-label" for="instructor">Instruktorius</label>
      <select name="instructor" id="instructor" class="form-control instructor"<?php if (!$this->HasPermission('Flight Manager')) echo ' disabled="disabled"'; ?>>
	<option value=""></option>
<?php foreach ($instructors['results'] as $user) { ?>
	<option value="<?php echo $user->id ?>"<?php echo (!empty($_POST['instructor']) && $_POST['instructor'] == $user->id) || (!empty($results['flight']->instructor) && $results['flight']->instructor == $user->id) ? ' selected="selected"' : NULL ?>><?php echo $user->name ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label class="control-label" for="airplane_id">Orlaivis</label>
      <select name="airplane_id" id="airplane_id" class="form-control airplane"<?php if (!$this->HasPermission('Flight Manager')) echo ' disabled="disabled"'; ?>>
	<option value=""></option>
<?php foreach ($airplanes['results'] as $airplane) { ?>
	<option value="<?php echo $airplane->id ?>"<?php echo (!empty($_POST['airplane_id']) && $_POST['airplane_id'] == $airplane->id) || (!empty($results['flight']->airplane_id) && $results['flight']->airplane_id == $airplane->id) ? ' selected="selected"' : NULL ?>><?php echo $airplane->name ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group amount qty"<?php if (!$this->HasPermission('Flight Manager')) echo ' disabled="disabled"'; ?>>
      <?php echo theme('number', 'amount', 'Kiekis', $results['flight'], $_POST) ?>
    </div>

<?php if (!empty($currentService->unit)) { ?>
    <div class="form-group amount_unit qty"<?php if (!$this->HasPermission('Flight Manager')) echo ' disabled="disabled"'; ?>>
      <?php echo theme('number', 'amount_unit', 'Papildoma kaina už <span class="service_unit" style=""> * ' . $currentService->unit . '</span>', $results['flight'], $_POST) ?>
    </div>
<?php } ?>

    <div class="form-group duration time"<?php if (!$this->HasPermission('Flight Manager') && !$isOwner) echo ' disabled="disabled"'; ?>>
      <?php $d = isset($_POST['duration']) ? $_POST['duration'] : (isset($results['flight']->duration) ? floatval($results['flight']->duration) : NULL); ?>
      <?php echo theme('time', 'duration', 'Trukmė', $results['flight'], array('duration' => $d)) ?>
    </div>

    <div class="form-group price"<?php if (!$this->HasPermission('Flight Manager')) echo ' disabled="disabled"'; ?>>
      <?php echo theme('number', 'price', 'Kaina', $results['flight'], $_POST) ?>
    </div>

    <div class="buttons">
<?php   if ($this->HasPermission('Flight Manager') || $isOwner) { ?>
      <input type="submit" class="btn btn-sm btn-primary" name="saveChanges" value="Saugoti" />
<?php } ?>
      <a href="index.php?action=flight" class="btn btn-sm">Atšaukti</a>
    </div>

  </fieldset>
</form>
