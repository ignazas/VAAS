<div class="page-header"><h1>Skrydžių redagavimas</h1></div>
<div class="col-md-12">
  <table class="table table-striped">
    <thead>
      <tr>
	<th>#</th>
	<th>Data</th>
	<th>Orlaivis</th>
	<th>Keleivis/Pirkėjas</th>
	<th>Instruktorius</th>
	<th>Užduotis</th>
	<th>Trukmė</th>
	<th>Kiekis</th>
      </tr>
    </thead>
	<tbody>
<?php foreach ( $results['flights'] as $flight) { ?>


      <tr>
	<td>
	  <a href="admin.php?action=flight&amp;view=View&amp;id=<?php echo $flight->record_id ?>"><?php echo $flight->record_id ?></a>
	</td>
	<td>
	  <?php echo $flight->date ?>
	</td>
	<td>
	  <?php echo $flight->airplane_registration ?>
	</td>
	<td>
	  <?php echo $flight->payer ?>
	</td>
	<td>
	  <?php echo $flight->instructor ?>
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
 	  <a class="btn btn-xs btn-default" href="admin.php?action=flight&amp;view=Edit&amp;id=<?php echo $flight->record_id ?>">Redaguoti</a>
	</td>
	<td>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti įrašą <?php echo $flight->record_id ?>?')" href="admin.php?action=flight&amp;view=Delete&amp;id=<?php echo $flight->record_id ?>">Pašalinti</a>
	</td>
      </tr>


<?php } ?>
	</tbody>
  </table>
  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=flight&amp;view=NewItem">Pridėti naują skrydį</a>
</div>
