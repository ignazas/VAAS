<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a><br />

<form class="form-horizontal" action="" method="POST">
  <fieldset>

    <!-- Form Name -->
    <legend>Įtraukti skrydį</legend>

    <!-- Text input-->
    <div class="form-group">
		<label class="control-label" for="date">Data</label>
		<input id="date" name="date" class="form-control input-md" type="text" maxlength="10" value="<?php ?>">
		<label class="control-label" for="callsign">Registracija</label>
      	<input id="callsign" name="callsign" class="form-control input-md" type="text" value="">
		<label class="control-label" for="pilot">Pilotas</label>
		<input id="pilot" name="pilot" class="form-control input-md" type="text" value="">
		<label class="control-label" for="passenger">Keleivis</label>
		<input id="passenger" name="passenger" class="form-control input-md" type="text" value="">
		<label class="control-label" for="task">Užduotis</label>
		<input id="task" name="task" class="form-control input-md" type="text" value="">
		<label class="control-label" for="amount">Kiekis</label>
		<input id="amount" name="amount" class="form-control input-md" type="text" value="">
		<label class="control-label" for="duration">Trukmė</label>
		<input id="duration" name="duration" class="form-control input-md" type="text" value="">	
    <label class="control-label" for="singlebutton"></label>
	<button id="submit" name="saveChanges" class="btn btn-primary">Įtraukti</button>
    </div>

  </fieldset>
</form>
