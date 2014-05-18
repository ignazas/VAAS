<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

<div class="container">
	<div class="page-header"><h1>Visos registracijos</h1></div>
      
      <div class="col-md-8">
      
	<?php if ( isset( $BookingList['errorMessage'] ) ) { ?>
		<div class="alert alert-danger">
			<strong>Klaida!</strong> <?php echo $BookingList['errorMessage'] ?>
		</div>
	<?php } ?>
	<?php if ( isset( $BookingList['statusMessage'] ) ) { ?>
		<div class="alert alert-success">
        <strong>Atlikta!</strong> <?php echo $BookingList['statusMessage'] ?>
      </div>
	<?php } ?>
	
      	<table class="table table-striped">
      		<tr>
          	<th>#</th>
			<th>Data</th>
			<th>Laikas</th>
			<th>Vartotojas</th>
			<th>Aprašymas</th>
			<th></th>
          	</tr>
          <?php foreach ( $BookingList['bookings'] as $booking ) { 
          	if($booking['status']=="vyksta") {echo "<tr class=\"success\">";} elseif($booking['status']=="nevyksta") {echo "<tr class=\"danger\">";}
          		echo "<td>".$booking['event_id']."</td>";
				echo "<td>".$booking['event_date']."</td>";
				echo "<td>".$booking['event_time']."</td>";
				echo "<td>".$booking['event_title']."</td>";
				echo "<td>".$booking['event_desc']."</td>";
				echo "<td>"; ?> 
				<form action="admin.php">
          		<input type="hidden" name="bookingId" value="<?php echo $booking['event_id']; ?>"/>
 				<button type="submit" name="action" onclick="return confirm('Ar tikrai norite pašalinti registraciją?')" class="btn btn-xs btn-danger" value="deleteBooking">Pašalinti</button>
				</form>
				<?php echo "</td>"; 
          		echo "</tr>";
		  	} 
		  ?>
		</table>
        </div>
        
      <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Info</h3>
            </div>
            <div class="panel-body">
              <p>Čia yra visos visų narių registracijos.</p>
              <p>Žalia spalva pažymėtos registracijos patvirtintomis dienomis, raudona - dienomis, kuriomis skrydžiai nevykdomi.</p>
            </div>
          </div>
        </div>
      

    </div> <!-- /container -->


<?php include "templates/include/footer.php" ?>