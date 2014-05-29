<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>


<div class="container">
	<div class="page-header"><h1>Orlaivių redagavimas</h1></div>
	<div class="col-md-8">
		<?php if ( isset( $ac['errorMessage'] ) ) { ?>
		<div class="alert alert-danger">
			<strong>Klaida!</strong> <?php echo $ac['errorMessage'] ?>
		</div>
		<?php } ?>
		<?php if ( isset( $ac['statusMessage'] ) ) { ?>
		<div class="alert alert-success">
			<strong>Atlikta!</strong> <?php echo $ac['statusMessage'] ?>
		</div>
		<?php } ?>
		<table class="table table-striped">
			<tr>
			<th>Šaukinys</th>
			<th>Modelis</th>
			<th></th>
			<th></th>
          	</tr>
			<?php 
			foreach ( $ac['ac'] as $aircraft) {
				echo "<tr><td>" . $aircraft['callsign'] . "</td><td>" . $aircraft['model']. "</td><td>";  ?>
				<form action="admin.php">
          		<input type="hidden" name="callsign" value="<?php echo $aircraft['callsign']; ?>"/>
 				<button type="submit" name="action" onclick="return confirm('Ar tikrai norite pašalinti orlaivį?')" class="btn btn-xs btn-danger" value="deleteAircraft">Pašalinti</button>
				</form>
				</td>
				<td>
				<form action="admin.php">
          		<input type="hidden" name="callsign" value="<?php echo $aircraft['callsign']; ?>"/>
 				<button type="submit" name="action" class="btn btn-xs btn-orig" value="editAircraft">Redaguoti</button>
				</form>
				</td>
				</tr>
			<?php }
			?>
		</table>
		<br />
 	<form action="admin.php">
 		<button type="submit" name="action" class="btn btn-sm btn-primary" value="addAircraft">Pridėti orlaivį</button>
	</form>
	</div>
</div> <!-- /container -->


<?php include "templates/include/footer.php" ?>