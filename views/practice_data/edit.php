<form id="practice-edit" class="form-horizontal" action="" method="POST" role="form">
  <input type="hidden" name="id" value="<?php echo $results['practice_data']->id ?>" />
  <fieldset>
    <legend>Redaguoti skrydį</legend>

    <div class="row">
    <div class="col-md-5">

    <div class="form-group">
      <?php echo theme('date', 'date', 'Data', $results['practice_data'], $_POST) ?>
    </div>

    <div class="form-group">
      <label class="control-label" for="practice_id">Pratimas</label>
      <select name="practice_id" id="practice_id" class="form-control">
	<option value=""></option>
<?php foreach ($results['practices']['results'] as $practice) { ?>
	<option value="<?php echo $practice->id ?>"<?php echo (!empty($_POST['practice_id']) && $_POST['practice_id'] == $practice->id) || (!empty($results['practice_data']->practice_id) && $results['practice_data']->practice_id == $practice->id) ? ' selected="selected"' : NULL ?>><?php echo $practice->title ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <?php echo theme('number', 'count', 'Skrydžių kiekis', $results['practice_data'], $_POST) ?>
    </div>

    <div class="form-group">
      <?php echo theme('number', 'time', 'Laikas, min', $results['practice_data'], $_POST) ?>
    </div>

    </div>
    <div class="col-md-2">
    </div>
    <div class="col-md-5">

    <div class="form-group">
      <label class="control-label" for="user">Mokinys</label>
      <select name="user_id" id="user" class="form-control">
	<option value=""></option>
<?php foreach ($results['users']['results'] as $user) { ?>
	<option value="<?php echo $user->id ?>"<?php echo (!empty($_POST['user_id']) && $_POST['user_id'] == $user->id) || (!empty($results['practice_data']->user_id) && $results['practice_data']->user_id == $user->id) ? ' selected="selected"' : NULL ?>><?php echo $user->name ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label class="control-label" for="instructor">Instruktorius</label>
      <select name="instructor_id" id="instructor" class="form-control">
	<option value=""></option>
<?php foreach ($results['instructors']['results'] as $user) { ?>
	<option value="<?php echo $user->id ?>"<?php echo (!empty($_POST['instructor_id']) && $_POST['instructor_id'] == $user->id) || (!empty($results['practice_data']->instructor_id) && $results['practice_data']->instructor_id == $user->id) ? ' selected="selected"' : NULL ?>><?php echo $user->name ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label class="control-label" for="airplane_id">Sklandytuvas</label>
      <select name="airplane_id" id="airplane_id" class="form-control">
	<option value=""></option>
<?php foreach ($results['airplanes']['results'] as $airplane) { ?>
      <option value="<?php echo $airplane->id ?>"<?php echo (!empty($_POST['airplane_id']) && $_POST['airplane_id'] == $airplane->id) || (!empty($results['practice_data']->airplane_id) && $results['practice_data']->airplane_id == $airplane->id) ? ' selected="selected"' : NULL ?>><?php echo $airplane->name . (!empty($airplane->reg_num) ? ' (' . $airplane->reg_num . ')' : NULL) ?></option>
<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <?php echo theme('text', 'comments', 'Komentarai', $results['practice_data'], $_POST) ?>
    </div>

    </div>
    </div>

    <div class="buttons">
      <input type="submit" class="btn btn-sm btn-primary" name="saveChanges" value="Saugoti" />
      <a href="index.php?action=flight" class="btn btn-sm">Atšaukti</a>
    </div>

  </fieldset>
</form>
