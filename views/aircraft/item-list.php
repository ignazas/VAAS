<div class="page-header"><h1>Orlaiviai</h1></div>
<div class="col-md-12">
  <table class="table table-striped">
    <thead>
      <tr>
	<th style="width:100px">Reg Nr.</th>
	<th style="width:100px">Tipas</th>
	<th style="width:100px">Ser. Nr</th>
	<th style="width:100px">Pirmas pilotas</th>
	<th style="width:100px">Antras pilotas</th>
	<th style="width:100px">Trečias pilotas</th>
	<th>Pastabos</th>
<?php if ($this->HasPermission()) { ?>
	<th style="width:60px;"></th>
	<th style="width:69px;"></th>
<?php } ?>
      </tr>
    </thead>
	<tbody>
<?php foreach ( $results['aircrafts'] as $aircraft) { ?>
      <tr>
	<td>
	  <a href="admin.php?action=aircraft&amp;view=View&amp;id=<?php echo $aircraft->id ?>">
	    <?php echo theme('display', 'reg_num', NULL, $aircraft) ?>
	    <?php echo empty($aircraft->reg_num) ? '---' : NULL ?>
	  </a>
	</td>
	<td>
	  <?php echo theme('display', 'name', NULL, $aircraft) ?>
	</td>
	<td>
	  <?php echo theme('display', 'serial_num', NULL, $aircraft) ?>
	</td>
	<td>
	  <?php echo theme('display', 'first_pilot', NULL, $aircraft) ?>
	</td>
	<td>
	  <?php echo theme('display', 'second_pilot', NULL, $aircraft) ?>
	</td>
	<td>
	  <?php echo theme('display', 'third_pilot', NULL, $aircraft) ?>
	</td>
	<td>
	  <?php echo theme('display', 'remarks', NULL, $aircraft) ?>
	</td>
<?php if ($this->HasPermission()) { ?>
	<td>
 	  <a class="btn btn-xs btn-default" href="admin.php?action=aircraft&amp;view=Edit&amp;callsign=<?php echo $aircraft->id ?>">Redaguoti</a>
	</td>
	<td>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti orlaivį <?php echo $aircraft->reg_num ?>?')" href="admin.php?action=aircraft&amp;view=Delete&amp;id=<?php echo $aircraft->id ?>">Pašalinti</a>
	</td>
<?php } ?>
      </tr>
<?php } ?>
	</tbody>
  </table>
<?php if (UserHelper::has_permission()) { ?>
  <br />
  <div class="buttons">
    <a class="btn btn-sm btn-primary" href="index.php?action=aircraft&amp;view=NewItem">Kurti naują orlaivį</a>
  </div>
<?php } ?>
</div>
