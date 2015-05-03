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
	  <?php echo theme('display', 'no', NULL, $practice->practice) ?> / <?php echo theme('display', 'title', NULL, $practice->practice) ?>
	</td>
	<td class="estimate">
	  <?php echo theme('display', 'count', NULL, $practice) ?> / <?php echo theme('display_hhmm', 'time', NULL, $practice) ?>
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
	<td>
 	  <a class="btn btn-xs btn-default" href="admin.php?action=practice&amp;view=EditData&amp;id=<?php echo $practice->id ?>">Redaguoti</a>
	</td>
	<td>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti įrašą <?php echo $practice->id ?>?')" href="admin.php?action=practice&amp;view=DeleteData&amp;id=<?php echo $practice->id ?>">Pašalinti</a>
	</td>
      </tr>


<?php } ?>
	</tbody>
  </table>

</div>
