<div class="page-header"><h1>Skrydžių redagavimas</h1></div>
<div class="col-md-8">
  <table class="table table-striped">
    <thead>
      <tr>
	<th>#</th>
	<th>Data</th>
	<th>Orlaivis</th>
	<th>Pilotas Instruktorius</th>
	<th>Keleivis Mokinys</th>
	<th>Užduotis</th>
	<th>Trukmė</th>
	<th>Kiekis</th>
      </tr>
    </thead>
	<tbody>
<?php foreach ( $results['flights'] as $flight) { ?>


      <tr>
	<td>
	  <a href="admin.php?action=flight&amp;view=View&amp;id=<?php echo $flight->id ?>"><?php echo $flight->id ?></a>
	</td>
	<td>
	  <?php echo $flight->date ?>
	</td>
	<td>
	  <?php echo $flight->callsign ?>
	</td>
	<td>
	  <?php echo $flight->pilot ?>
	</td>
	<td>
	  <?php echo $flight->passenger ?>
	</td>
	<td>
	  <?php echo $flight->task ?>
	</td>
	<td>
	  <?php echo $flight->duration ?>
	</td>
	<td>
	  <?php echo $flight->amount ?>
	</td>
	<td>
 	  <a class="btn btn-xs btn-default" href="admin.php?action=flight&amp;view=Edit&amp;id=<?php echo $flight->id ?>">Redaguoti</a>
	</td>
	<td>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti įrašą <?php echo $flight->id ?>?')" href="admin.php?action=flight&amp;view=Delete&amp;id=<?php echo $flight->id ?>">Pašalinti</a>
	</td>
      </tr>


<?php } ?>
	</tbody>
  </table>
  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=flight&amp;view=NewItem">Pridėti naują skrydį</a>
</div>
