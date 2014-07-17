<div class="page-header"><h1>Nariai</h1></div>

<div class="col-xs-12">
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
<?php foreach ($results['users'] as $user) { ?>
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
	</td>
<?php } ?>
      </tr>
<?php } ?>
    </tbody>

  </table>
  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=user&amp;view=NewItem">Kurti naują naudotoją</a>
</div>
