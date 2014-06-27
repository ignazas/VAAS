<div class="page-header"><h1>Paslaugų redagavimas</h1></div>
<div class="col-md-8">
  <table class="table table-striped">
    <thead>
      <tr>
	<th>#</th>
	<th>Pavadinimas</th>
	<th>Nuolaidos netaikomos</th>
	<th>Kaina</th>
	<th>Aprašymas</th>
      </tr>
    </thead>
	<tbody>
<?php foreach ( $results['services'] as $service) { ?>
      <tr>
	<td>
	  <a href="admin.php?action=service&amp;view=View&amp;id=<?php echo $service->id ?>"><?php echo $service->id ?></a>
	</td>
	<td>
	  <?php echo $service->title ?>
	</td>
	<td>
	  <?php echo $service->discount_disabled ?>
	</td>
	<td>
	  <?php echo $service->amount/100 ?>
	</td>
	<td>
	  <?php echo $service->description ?>
	</td>
	<td>
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
