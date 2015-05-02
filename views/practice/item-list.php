<?php
$phases = array();
foreach ( $results['practice']['results'] as $practice) {
  if (empty($phases[$practice->phase_no]))
    $phases[$practice->phase_no] = array();
  $phases[$practice->phase_no][] = $practice;
}
?>

<div class="page-header"><h1>Skrydžių praktika: <?php print $results['user']->name ?></h1></div>

<?php foreach ($phases as $phase_no => $practices) { ?>

<div class="col-md-12">
  <div class="page-header"><h2>Etapas: <?php print $phase_no ?></h2></div>

  <table class="table table-striped table-bordered table-hover practice">
    <thead>
      <tr>
	<th rowspan="2">Pratimo Nr.</th>
	<th rowspan="2">Pavadinimas</th>
	<th colspan="5">Skrydžių skaičius / laikas</th>
	<th rowspan="2">Instruktažas</th>
<?php if (!empty($results['user'])) { ?>
	<th rowspan="2">Atlikta</th>
<?php } ?>
	<th rowspan="2">Pratimo aprašymas</th>
      </tr>
      <tr>
	<th class="estimate">Su<br/>instruk-<br/>toriumi</th>
	<th class="estimate">Sava-<br/>rankiš-<br/>kai</th>
	<th class="estimate">Ratu</th>
	<th class="estimate">Zona</th>
	<th class="estimate">Marš-<br/>rutu</th>
      </tr>
    </thead>
	<tbody>
<?php foreach ($practices as $practice) { ?>
      <tr>
	<td>
	  <?php echo theme('display', 'no', NULL, $practice) ?>
	</td>
	<td>
	  <?php echo theme('display', 'title', NULL, $practice) ?>
	</td>
	<td class="estimate">
	  <?php echo theme('display', 'flight_with_instructor_count', NULL, $practice) ?> / <?php echo theme('display_hhmm', 'flight_with_instructor_time', NULL, $practice) ?>
	</td>
	<td class="estimate">
	  <?php echo theme('display', 'flight_individual_count', NULL, $practice) ?> / <?php echo theme('display_hhmm', 'flight_individual_time', NULL, $practice) ?>
	</td>
	<td class="estimate">
	  <?php echo theme('display', 'flight_box_count', NULL, $practice) ?> / <?php echo theme('display_hhmm', 'flight_box_time', NULL, $practice) ?>
	</td>
	<td class="estimate">
	  <?php echo theme('display', 'flight_zone_count', NULL, $practice) ?> / <?php echo theme('display_hhmm', 'flight_zone_time', NULL, $practice) ?>
	</td>
	<td class="estimate">
	  <?php echo theme('display', 'flight_route_count', NULL, $practice) ?> / <?php echo theme('display_hhmm', 'flight_route_time', NULL, $practice) ?>
	</td>
	<td>
	  <?php echo theme('display_hhmm', 'briefing', NULL, $practice) ?>
	</td>
<?php if (!empty($results['user'])) { ?>
	<td class="<?php echo empty($results['practice_data'][$practice->id]['count']) && empty($results['practice_data'][$practice->id]['time']) ? 'danger' : ($results['practice_data'][$practice->id]['count'] < $practice->flight_with_instructor_count + $practice->flight_individual_count ? 'warning' : 'success') ?>">
<?php  if (isset($results['practice_data'][$practice->id])) { ?>
<?php echo theme('display', 'count', NULL, NULL, $results['practice_data'][$practice->id]) ?> / <?php echo theme('display_hhmm', 'time', NULL, NULL, $results['practice_data'][$practice->id]) ?>
<?php  } ?>
          <a class="btn btn-sm btn-primary" href="index.php?action=practice&amp;view=NewData&amp;user_id=<?php echo $results['user']->id ?>&amp;practice_id=<?php echo $practice->id ?>">Pridėti</a>
	</td>
<?php } ?>
	<td>
	  <?php echo theme('display', 'description', NULL, $practice) ?>
	</td>
      </tr>


<?php } ?>
	</tbody>
  </table>

<?php } ?>

  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=practice&amp;view=NewData&amp;user_id=<?php echo $results[user]->id ?>">Pridėti naują skrydį</a>
</div>
