<div class="page-header"><h1>Orlaivių redagavimas</h1></div>
<div class="col-md-12">
  <table class="table table-striped">
    <thead>
      <tr>
	<th style="width:100px">Šaukinys</th>
	<th>Modelis</th>
	<th style="width:60px;"></th>
	<th style="width:69px;"></th>
      </tr>
    </thead>
	<tbody>
<?php foreach ( $results['aircrafts'] as $aircraft) { ?>


      <tr>
	<td>
	  <a href="admin.php?action=aircraft&amp;view=View&amp;callsign=<?php echo $aircraft->callsign ?>"><?php echo $aircraft->callsign ?></a>
	</td>
	<td>
	  <?php echo $aircraft->model ?>
	</td>
	<td>
 	  <a class="btn btn-xs btn-default" href="admin.php?action=aircraft&amp;view=Edit&amp;callsign=<?php echo $aircraft->callsign ?>">Redaguoti</a>
	</td>
	<td>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti orlaivį <?php echo $aircraft->callsign ?>?')" href="admin.php?action=aircraft&amp;view=Delete&amp;callsign=<?php echo $aircraft->callsign ?>">Pašalinti</a>
	</td>
      </tr>


<?php } ?>
	</tbody>
  </table>
  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=aircraft&amp;view=NewItem">Kurti naują orlaivį</a>
</div>
