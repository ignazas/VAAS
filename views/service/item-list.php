<div class="page-header"><h1>Paslaugų redagavimas</h1></div>
<div class="col-md-12">
  <table class="table table-striped">
    <thead>
      <tr>
	<th>Skrydis</th>
	<th>Pavadinimas</th>
	<th>Nuolaida taikoma</th>
	<th>Kaina</th>
	<th>Papildoma kaina</th>
	<th>Ar kaina už skrydžio laiką</th>
	<th>Trukmė pagal nutylėjimą</th>
	<th>Aprašymas</th>
	<th></th>
	<th></th>
      </tr>
    </thead>
	<tbody>
<?php foreach ( $results['services'] as $service) { ?>
      <tr>
	<td>
	  <?php echo !empty($service->is_flight) ? '<i class="glyphicon glyphicon-ok"></i>' : '' ?>
	</td>
	<td>
	  <?php echo $service->title ?>
	</td>
	<td>
	  <?php echo $service->is_discount == 1 ? '<i class="glyphicon glyphicon-ok"></i>' : '' ?>
	</td>
	<td>
	  <?php echo theme('display_money', 'amount', NULL, $service) ?>
	</td>
	<td>
<?php if (!empty($service->amount_unit)) { ?>
    <?php echo theme('display', 'amount_unit_title', NULL, $service, array('amount_unit_title' => $service->amount_unit . '€/' . $service->unit )) ?>
<?php } ?>
	</td>
	<td>
	  <?php echo !empty($service->is_price_for_duration) ? '<i class="glyphicon glyphicon-ok"></i>' : '' ?>
	</td>
	<td>
      <?php echo theme('display_time', 'default_duration', NULL, $service, array('default_duration' => !empty($service->default_duration) ? floatval($service->default_duration) : NULL)) ?>
	</td>
	<td>
	  <?php echo $service->description ?>
	</td>
	<td>
 	  <a class="btn btn-xs btn-default" href="admin.php?action=service&amp;view=View&amp;id=<?php echo $service->id ?>">Peržiūrėti</a>
 	  <a class="btn btn-xs btn-default" href="admin.php?action=service&amp;view=Edit&amp;id=<?php echo $service->id ?>">Redaguoti</a>
	</td>
	<td>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti įrašą <?php echo $service->title ?>?')" href="admin.php?action=service&amp;view=Delete&amp;id=<?php echo $service->id ?>">Pašalinti</a>
	</td>
      </tr>


<?php } ?>
	</tbody>
  </table>
  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=service&amp;view=NewItem">Pridėti naują paslaugą</a>
</div>
