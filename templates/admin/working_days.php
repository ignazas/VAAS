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
<?php   foreach ($workingDays['days'] as $day_events) { ?>
<?php     foreach ($day_events as $day) { ?>
        <tr class="<?php echo $day['status']=="vyksta" ? 'success' : 'danger' ?>">
	    <td class="date"><?php echo $day['day'] ?></td>
	    <td class="status"><?php echo $day['status'] ?></td>
	    <td class="confirmed"><?php echo $day['confirmed'] ?></td>
	    <td class="reason"><?php echo $day['reason'] ?></td>
	    <td style="white-space: nowrap;">
	      <button type="submit" name="action" onclick="jQuery('[name=day]').val(jQuery('td.date', jQuery(this).parent().parent()).text());jQuery('[name=status]').val(jQuery('td.status', jQuery(this).parent().parent()).text());jQuery('[name=status]').trigger('chosen:updated');;jQuery('[name=reason]').val(jQuery('td.reason', jQuery(this).parent().parent()).text());" class="btn btn-xs">Redaguoti</button>
	      <form action="admin.php" style="display: inline-block;">
		<input type="hidden" name="day" value="<?php echo $day['day']; ?>"/>
		<input type="hidden" name="status" value="<?php echo $day['status']; ?>"/>
		<button type="submit" name="action" onclick="return confirm('Ar tikrai norite pašalinti dienos žymę?')" class="btn btn-xs btn-danger" value="deleteDay">Pašalinti</button>
	      </form>
	    </td>
	</tr>
<?php     } ?>
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
		<div class="input-group" id="day_datepicker">
                  <input type="text" name="day" id="day" class="form-control" />
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
		  <script type="text/javascript">
		    $(function () {
                    $('#day_datepicker').datetimepicker({locale:'lt', format: 'YYYY-MM-DD', defaultDate: '<?php echo !empty($_GET["day"]) ? $_GET["day"] : date('Y-m-d') ?>'});
		    });
		  </script>
		</div>
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
