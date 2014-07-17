<?php
require_once dirname(__FILE__) . '/../../helpers/user.inc';
UserHelper::check_access();

include "templates/include/header.php";
include "templates/include/top-menu.php";
?>


<div class="container">
  <div class="page-header"><h1>Darbo dienų atžymėjimas</h1></div>

  <div class="col-md-8">
    <?php if ( isset( $workingDays['errorMessage'] ) ) { ?>
    <div class="alert alert-danger">
      <strong>Klaida!</strong> <?php echo $workingDays['errorMessage'] ?>
    </div>
    <?php } ?>
    <?php if ( isset( $workingDays['statusMessage'] ) ) { ?>
    <div class="alert alert-success">
      <strong>Atlikta!</strong> <?php echo $workingDays['statusMessage'] ?>
    </div>
    <?php } ?>

    <table class="table">
      <thead>
	<tr class="active">
	  <th>Data</th>
	  <th>Statusas</th>
	  <th>Patvirtino</th>
	  <th>Pastaba</th>
	  <th></th>
	</tr>
      </thead>
      <tbody>
<?php if (!empty($workingDays['days'])) { ?>
<?php   foreach ($workingDays['days'] as $day) { ?>
        <tr class="<?php echo $day['status']=="vyksta" ? 'success' : 'danger' ?>">
	    <td><?php echo $day['day'] ?></td>
	    <td><?php echo $day['status'] ?></td>
	    <td><?php echo $day['confirmed'] ?></td>
	    <td><?php echo $day['reason'] ?></td>
	    <td>
	      <form action="admin.php">
		<input type="hidden" name="day" value="<?php echo $day['day']; ?>"/>
		<button type="submit" name="action" onclick="return confirm('Ar tikrai norite pašalinti dienos žymę?')" class="btn btn-xs btn-danger" value="deleteDay">Pašalinti</button>
	      </form>
	    </td>
	</tr>
<?php   } ?>
<?php } ?>
</tbody>
    </table>
    <!--<div id="prideti">
	<a class="addDay" href="#">Pridėti dar vieną dieną</a>
    </div>-->

  </div>

  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Skrydžių planas</h3>
      </div>
      <div class="panel-body">
	<div id="addDay">
	  <form role="form" method="get" action="admin.php" class="col-xs-12 form-horizontal">
	    <input type="hidden" name="confirmed" value="<?php echo $_SESSION['user']['name']; ?>"/>
	    <input type="hidden" name="destination" value="admin.php?action=admin/working_days"/>
	    <div class="form-group">
	      <label for="status" class="col-sm-3 control-label">Data</label>
	      <div class="col-sm-9">
		<input id="day" placeholder="2014-01-01" type="date" class="form-control" name="day" value="<?php echo date('Y-m-d') ?>">
	      </div>
	    </div>
	    <div class="form-group">
	      <label for="status" class="col-sm-3 control-label">Būsena</label>
	      <div class="col-sm-9">
		<select name="status" class="form-control">
		  <option value="vyksta">Vyksta</option>
		  <option value="nevyksta">Nevyksta</option>
		  <option value="talka">Dalyvavimas būtinas</option>
		</select>
	      </div>
	    </div>
	    <div class="form-group">
	      <label for="reason" class="col-sm-3 control-label">Pastaba</label>
	      <div class="col-sm-9">
		<textarea name="reason" class="form-control"></textarea>
	      </div>
	    </div>
	    <div class="form-group">
	      <div class="col-sm-offset-3 col-sm-9">
		<button type="submit" name="action" id="action" class="btn btn-primary" value="addDay">Žymėti</button>
	      </div>
	    </div>
	  </form>
	</div>
      </div>
    </div>
  </div>

</div> <!-- /container -->

<?php include "templates/include/footer.php"; ?>
