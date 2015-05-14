<div class="page-header"><h1>Nariai</h1></div>

<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Filtrai</h3>
    </div>
    <div class="panel-body">
      <div id="addDay">
	<form role="form" method="get" action="" class="col-xs-12 form-horizontal">
	  <input type="hidden" name="action" value="user" />
	  <input type="hidden" name="view" value="ItemList" />
	  <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Paieška</label>
	    <div class="col-sm-9">
	      <input type="text" name="search" class="form-control" value="<?php echo !empty($_GET['search']) ? $_GET['search'] : NULL ?>" />
            </div>
          </div>
	  <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Būsena</label>
	    <div class="col-sm-9">
	      <select name="group" class="form-control">
		<option value="">Visi</option>
<?php foreach ($results['groups']['results'] as $group) { ?>
		<option value="<?php echo $group->id ?>"<?php echo !empty($_GET['group']) && $group->id == $_GET['group'] ? 'selected="selected"' : NULL ?>><?php echo $group->title ?></option>
<?php } ?>
              </select>
            </div>
          </div>
	  <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Instruktorius</label>
	    <div class="col-sm-9">
	      <select name="instructor" class="form-control">
		<option value="">Visi</option>
		<option value="0"<?php echo !empty($_GET['instructor']) && 0 == $_GET['instructor'] ? 'selected="selected"' : NULL ?>>Ne</option>
		<option value="1"<?php echo !empty($_GET['instructor']) && 1 == $_GET['instructor'] ? 'selected="selected"' : NULL ?>>Taip</option>
              </select>
            </div>
          </div>
          <div class="form-group">
	    <div class="col-sm-offset-3 col-sm-9">
	      <button type="submit" class="btn btn-primary">Filtruoti</button>
	    </div>
	  </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="col-xs-12">
  <label>Įrašų: <?php echo $results['users']['totalRows'] ?></label>
  <table class="table table-striped">
    <thead>
      <tr>
	<th class="col-lg-2 col-xs-1 hidden-xs hidden-sm"></th>
	<th class="col-xs-4">Narys</th>
	<th>Pastaba</th>
<?php if ($this->HasPermission()) { ?>
	<th style="width:60px;"></th>
<?php } ?>
      </tr>
    </thead>

    <tbody>
<?php foreach ($results['users']['results'] as $user) { ?>
      <tr>
	<td class="col-lg-2 col-xs-1 hidden-xs hidden-sm">
          <a href="index.php?action=user&amp;view=View&amp;id=<?php echo $user->id ?>">
	    <?php echo theme('display_avatar', 'avatar', $user->name, $user) ?>
	  </a>
	</td>
	<td class="col-xs-4">
          <a href="index.php?action=user&amp;view=View&amp;id=<?php echo $user->id ?>">
	    <?php echo theme('display', 'name', NULL, $user) ?>
	  </a>
          <?php echo theme('display_email', 'email', NULL, $user) ?>
          <?php echo theme('display_phone', 'telephone1', NULL, $user) ?>
          <?php echo theme('display_phone', 'telephone2', NULL, $user) ?>
          <?php echo theme('display', 'birthdate', 'Gimtadienis', $user) ?>
          <?php //echo theme('display_email', 'email_to', 'Kontaktinis el. adresas', $user) ?>
          <?php echo theme('display', 'website', NULL, $user) ?>
	</td>
	<td>
          <?php echo theme('display', 'con_position', 'Pareigos', $user) ?>
	  <?php echo theme('display', 'usertype', 'Vartotojo tipas', $user) ?>
          <?php echo theme('display', 'registerDate', 'Užsiregistravo', $user) ?>
          <?php echo theme('display', 'lastvisitDate', 'Paskutinis apsilankymas', $user) ?>
	</td>
<?php if ($this->HasPermission() || (!empty($_SESSION['user']['id']) && $_SESSION['user']['id'] == $user->id)) { ?>
	<td>
 	  <a class="btn btn-xs btn-default" href="index.php?action=user&amp;view=Edit&amp;id=<?php echo $user->id ?>">Redaguoti</a>
<?php  if (UserHelper::has_permission()) { ?>
	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti įrašą <?php echo $user->name ?>?')" href="index.php?action=user&amp;view=Delete&amp;id=<?php echo $user->id ?>">Pašalinti</a>
<?php  } ?>
<?php  if (UserHelper::is_student($user)) { ?>
 	  <a class="btn btn-xs btn-default" href="index.php?action=practice&amp;user_id=<?php echo $user->id ?>">Skraidymų knygelė</a>
<?php  } ?>
	</td>
<?php } ?>
      </tr>
<?php } ?>
    </tbody>

  </table>
  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=user&amp;view=NewItem">Kurti naują naudotoją</a>
</div>
