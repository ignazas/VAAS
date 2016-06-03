<?php
$airplanes = array();
foreach ($results['flights']['results'] as $flight) {
  if (empty($airplanes[$flight->airplane_id])) $airplanes[$flight->airplane_id] = array('duration' => 0, 'amount' => 0);
  $airplanes[$flight->airplane_id]['duration'] += $flight->duration;
  $airplanes[$flight->airplane_id]['amount'] += $flight->amount;
}
?>

<div class="page-header"><h1>Skrydžiai</h1></div>

<div class="col-md-8">
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
	      <div class="input-group" id="date_datepicker">
                <input type="text" name="date" id="date" class="form-control" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
		<script type="text/javascript">
		  $(function () {
                  $('#date_datepicker').datetimepicker({locale:'lt', format: 'YYYY-MM-DD', defaultDate: '<?php echo !empty($_GET["date"]) ? $_GET["date"] : NULL ?>'});
		  });
		</script>
	      </div>
            </div>
          </div>
	  <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Paieška</label>
	    <div class="col-sm-9">
	      <input type="text" name="search" class="form-control" value="<?php echo !empty($_GET['search']) ? $_GET['search'] : NULL ?>" />
            </div>
          </div>
	  <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Lėktuvas</label>
	    <div class="col-sm-9">
	      <select name="aircraft" class="form-control">
		<option value="">Visi</option>
<?php foreach ($results['airplanes'] as $aircraftid => $aircraft) { ?>
		<option value="<?php echo $aircraft->id ?>"<?php echo !empty($_GET['aircraft']) && $aircraft->id == $_GET['aircraft'] ? 'selected="selected"' : NULL ?>><?php echo $aircraft->name ?> ( <?php echo $aircraft->reg_num ?>)</option>
<?php } ?>
              </select>
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

<div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Orlaivių laikai pagal filtrus</h3>
    </div>
    <div class="panel-body">
      <ul class="list-group">
<?php foreach ($airplanes as $planeid => $data) { ?>
        <li class="list-group-item">
	  <?php echo (!empty($results['airplanes'][$planeid]) ? ($results['airplanes'][$planeid]->name . ' (' . $results['airplanes'][$planeid]->reg_num . ')') : NULL) ?>:
	  <?php echo !empty($data['amount']) ? floatval($data['amount']) : NULL ?>
	  /
	  <?php echo DateHelper::time_as_string(!empty($data['duration']) ? floatval($data['duration']) : NULL) ?>
	</li>
<?php } ?>
      </ul>
    </div>
  </div>
</div>

<div class="col-md-12">
  <label>Įrašų: <?php echo $results['flights']['totalRows'] ?></label>
  <table class="table table-striped">
    <thead>
      <tr>
	<th style="width:90px;"><?php echo order_link('date', "index.php", 'Data') ?></th>
	<th><?php echo order_link('a.name', "index.php", 'Orlaivis') ?></th>
	<th><?php echo order_link('s.title', "index.php", 'Skrydis') ?></th>
	<th><?php echo order_link('u.name', "index.php", 'Pilotas') ?></th>
	<th><?php echo order_link('i.name', "index.php", 'Instruktorius') ?></th>
	<th><?php echo order_link('f.amount', "index.php", 'Kiekis') ?></th>
	<th><?php echo order_link('f.duration', "index.php", 'Trukmė') ?></th>
	<th><?php echo order_link('f.price', "index.php", 'Nuskaityta') ?></th>
	<th style="width:60px;"></th>
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
	  <?php echo theme('display', 'date', NULL, $flight) ?>
	</td>
	<td>
	  <?php echo !empty($results['airplanes'][$flight->airplane_id]) ? ($results['airplanes'][$flight->airplane_id]->name . ' (' . $results['airplanes'][$flight->airplane_id]->reg_num . ')') : NULL ?>
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
	<td>
	  <?php echo theme('display_money', 'price', NULL, $flight) ?>
	</td>
	<td>
	  <a class="btn btn-xs btn-default" href="admin.php?action=flight&amp;view=View&amp;id=<?php echo $flight->record_id ?>">Peržiūrėti</a>
	</td>
<?php   if ($this->HasPermission('Flight Manager') || ($flight->payer == UserHelper::get_id())) { ?>
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
<?php   if ($this->HasPermission('Flight Manager')) { ?>
  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=flight&amp;view=NewItem">Pridėti naują skrydį</a>
  <a class="btn btn-sm btn-default" href="index.php?action=flight&amp;view=Download&amp;date=<?php echo !empty($_GET['date']) ? $_GET['date'] : NULL ?>">Parsisiųsti</a>
<?php   } ?>
</div>
