<div class="page-header"><h1>Skrydžių praktika</h1></div>
<div class="col-md-12">
  <table class="table table-striped table-hover practice">
    <thead>
      <tr>
	<th>Data</th>
	<th>Pratimas</th>
	<th>Skrydžių skaičius / laikas</th>
	<th>Mokinys</th>
	<th>Instruktorius</th>
	<th>Sklandytuvas</th>
	<th>Komentarai</th>
	<th>Patvirtintas</th>
	<th style="width:60px;"></th>
	<th style="width:69px;"></th>
      </tr>
    </thead>
	<tbody>
<?php foreach ($results['practice_data']['results'] as $practice) { ?>
      <tr>
	<td>
	  <?php echo theme('display', 'date', NULL, $practice) ?>
	</td>
	<td>
    <?php echo theme('display', 'title', NULL, NULL, array('title' => $practice->practice->phase_no . (!empty($practice->practice->no) ? '.' . $practice->practice->no : NULL) . '. ' . $practice->practice->title)) ?>
	</td>
	<td class="estimate">
<?php if (!empty($practice->count) || !empty($practice->time)) { ?>
	  <?php echo theme('display', 'count', NULL, $practice) ?> / <?php echo theme('display_hhmm', 'time', NULL, $practice) ?>
<?php } ?>
	</td>
	<td class="estimate">
	  <?php echo theme('display', 'name', NULL, $practice->user) ?>
	</td>
	<td class="estimate">
	  <?php echo theme('display', 'name', NULL, $practice->instructor) ?>
	</td>
	<td class="estimate">
	  <?php echo theme('display', 'name', NULL, $practice->aircraft) ?>
	</td>
	<td>
	  <?php echo theme('display', 'comments', NULL, $practice) ?>
	</td>
	<td style="text-align: center;">
<?php if ($this->HasPermission('Flight Manager') || (!empty($user->instructor) && $practice->instructor_id == $user->id)) { ?>
           <input class="approve" type="checkbox"<?php echo empty($practice->approved) ? NULL : ' checked="checked"' ?> pid="<?php echo $practice->id ?>"/>
<?php } else { ?>
	  <?php echo theme('display_checkbox', 'approved', NULL, $practice) ?>
<?php } ?>
	</td>
	<td>
<?php if ($this->HasPermission('Flight Manager') || $practice->user->id == $user_id && empty($practice->approved)) { ?>
 	  <a class="btn btn-xs btn-default" href="admin.php?action=practice&amp;view=EditData&amp;id=<?php echo $practice->id ?>">Redaguoti</a>
<?php } ?>
	</td>
	<td>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti įrašą <?php echo $practice->id ?>?')" href="admin.php?action=practice&amp;view=DeleteData&amp;id=<?php echo $practice->id ?>">Pašalinti</a>
	</td>
      </tr>


<?php } ?>
	</tbody>
  </table>

</div>
