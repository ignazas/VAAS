<div class="page-header"><h1>Skrydžiai</h1></div>

<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Filtrai</h3>
    </div>
    <div class="panel-body">
      <div id="addDay">
	<form role="form" method="get" action="" class="col-xs-12 form-horizontal">
	  <input type="hidden" name="action" value="flight" />
	  <input type="hidden" name="view" value="ItemList" />
	  <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Data</label>
	    <div class="col-sm-9">
	      <input type="date" name="date" class="form-control" value="<?php echo !empty($_GET['date']) ? $_GET['date'] : NULL ?>" />
            </div>
          </div>
          <div class="form-group">
	    <div class="col-sm-offset-3 col-sm-9">
	      <button type="submit" class="btn btn-primary">Filtruoti</button>
	    </div>
	  </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="col-md-12">
  <table class="table table-striped">
    <thead>
      <tr>
	<th>#</th>
	<th><?php echo order_link('date', 'index.php?action=flight&view=ItemList', 'Data') ?></th>
	<th>Orlaivis</th>
	<th>Paslauga</th>
	<th>Keleivis/Pirkėjas</th>
	<th>Instruktorius</th>
	<th>Kiekis</th>
	<th>Trukmė</th>
<?php if ($this->HasPermission()) { ?>
	<th style="width:60px;"></th>
	<th style="width:69px;"></th>
<?php } ?>
      </tr>
    </thead>
	<tbody>
<?php foreach ( $results['flights']['results'] as $flight) { ?>


      <tr>
	<td>
	  <a href="admin.php?action=flight&amp;view=View&amp;id=<?php echo $flight->record_id ?>"><?php echo $flight->record_id ?></a>
	</td>
	<td>
	  <?php echo theme('display', 'date', NULL, $flight) ?>
	</td>
	<td>
	  <?php echo !empty($results['airplanes'][$flight->airplane_id]) ? $results['airplanes'][$flight->airplane_id]->name : NULL ?>
	</td>
	<td>
	  <?php echo !empty($results['services'][$flight->service_id]) ? $results['services'][$flight->service_id]->title : NULL ?>
	</td>
	<td>
	  <?php echo !empty($results['users'][$flight->payer]) ? $results['users'][$flight->payer]->name : NULL ?>
	</td>
	<td>
	  <?php echo !empty($results['users'][$flight->instructor]) ? $results['users'][$flight->instructor]->name : NULL ?>
	</td>
	<td>
	  <?php echo theme('display', 'amount', NULL, $flight) ?>
	</td>
	<td>
    <?php echo theme('display_time', 'time', NULL, $flight, array('time' => !empty($flight->duration) ? floatval($flight->duration) : NULL)) ?>
	</td>
<?php   if ($this->HasPermission()) { ?>
	<td>
 	  <a class="btn btn-xs btn-default" href="admin.php?action=flight&amp;view=Edit&amp;id=<?php echo $flight->record_id ?>">Redaguoti</a>
	</td>
	<td>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti įrašą <?php echo $flight->record_id ?>?')" href="admin.php?action=flight&amp;view=Delete&amp;id=<?php echo $flight->record_id ?>">Pašalinti</a>
	</td>
<?php   } ?>
      </tr>


<?php } ?>
	</tbody>
  </table>
  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=flight&amp;view=NewItem">Pridėti naują skrydį</a>
  <a class="btn btn-sm btn-default" href="index.php?action=flight&amp;view=Download&amp;date=<?php echo !empty($_GET['date']) ? $_GET['date'] : NULL ?>">Parsisiųsti</a>
</div>
