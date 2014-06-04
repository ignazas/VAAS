<?php require "common.php" ?>
<?php require "secure.php" ?>
<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

<div class="container">
  <?php include "templates/include/messages.inc" ?>
  <?php include "templates/include/errors.inc" ?>

  <div class="page-header"><h1>Mano registracijos</h1></div>

  <div class="col-md-8">

    <table class="table table-striped">
<thead>
      <tr>
        <th>#</th>
	<th>Data</th>
	<th>Laikas</th>
	<th>Aprašymas</th>
	<th></th>
      </tr>
      </thead>
      <tbody>
<?php foreach ( $BookingList['results'] as $booking ) { ?>
        <tr class="<?php echo $booking->day->status=='vyksta' ? 'success' : ($booking->day->status=='nevyksta' ? 'danger' : NULL) ?>">
          <td><?php echo $booking->event_id ?></td>
          <td><?php echo $booking->event_date ?></td>
          <td><?php echo $booking->event_time ?></td>
          <td><?php echo $booking->event_desc ?></td>
          <td>
            <form action="index.php">
              <input type="hidden" name="bookingId" value="<?php echo $booking->event_id; ?>"/>
 	            <button type="submit" name="action" onclick="return confirm('Ar tikrai norite atsisakyti registracijos?')" class="btn btn-xs btn-danger" value="deleteBooking">Atsisakyti</button>
            </form>
          </td>
        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Info</h3>
      </div>
      <div class="panel-body">
        <p>Čia yra visos patvirtintos registracijos į skraidymus.</p>
        <p>Žalia spalva pažymėtos registracijos patvirtintomis dienomis, raudona - dienomis, kuriomis skrydžiai nevykdomi.</p>
      </div>
    </div>
  </div>


</div> <!-- /container -->


<?php include "templates/include/footer.php" ?>