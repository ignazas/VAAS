<a class="b-close">[X]</a>

<form class="form-horizontal" action="" method="POST">
  <input type="hidden" name="old_callsign" value="<?php echo isset($_POST['old_callsign']) ? $_POST['old_callsign'] : $results['aircraft']->callsign ?>" />
  <fieldset>

    <!-- Form Name -->
    <legend>Įtraukti orlaivį</legend>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="callsign">Registracija</label>
      <div class="col-md-4">
	<input id="callsign" name="callsign" placeholder="LY-G??" class="form-control input-md" type="text" value="<?php echo isset($_POST['callsign']) ? $_POST['callsign'] : $results['aircraft']->callsign ?>">

      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="model">Modelis</label>
      <div class="col-md-4">
	<input id="model" name="model" placeholder="Bocian" class="form-control input-md" type="text" value="<?php echo isset($_POST['model']) ? $_POST['model'] : $results['aircraft']->model ?>">

      </div>
    </div>

    <!-- Button -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="singlebutton"></label>
      <div class="col-md-4">
	<button id="submit" name="saveChanges" class="btn btn-primary">Įtraukti</button>
      </div>
    </div>

  </fieldset>
</form>
