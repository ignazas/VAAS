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
	    <label for="status" class="col-sm-3 control-label">Nuo</label>
	    <div class="col-sm-9">
	      <div class="input-group" id="date_from_datepicker">
                <input type="text" name="date_from" id="date_from" class="form-control" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
		<script type="text/javascript">
		  $(function () {
              $('#date_from_datepicker').datetimepicker({locale:'lt', format: 'YYYY-MM-DD', defaultDate: '<?php echo !empty($_GET["date_from"]) ? $_GET["date_from"] : NULL ?>'});
              $('#date_from').on("keydown", function(e){
                  if (e.which == 13) {
                      $(this).closest('form').submit();          
                  }
              });
		  });
		</script>
	      </div>
            </div>
          </div>

      <div class="form-group">
	    <label for="status" class="col-sm-3 control-label">Iki</label>
	    <div class="col-sm-9">
	      <div class="input-group" id="date_to_datepicker">
                <input type="text" name="date_to" id="date_to" class="form-control" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
		<script type="text/javascript">
		  $(function () {
              $('#date_to_datepicker').datetimepicker({locale:'lt', format: 'YYYY-MM-DD', defaultDate: '<?php echo !empty($_GET["date_to"]) ? $_GET["date_to"] : NULL ?>'});
              $('#date_to').on("keydown", function(e){
                  if (e.which == 13) {
                      $(this).closest('form').submit();          
                  }
              });
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
	<th><?php echo order_link('f.amount', "index.php", 'Kiekis') ?> / 
	    <?php echo order_link('f.duration', "index.php", 'Trukmė') ?></th>
	<th><?php echo order_link('f.price', "index.php", 'Nuskaityta') ?></th>
<?php   if ($this->HasPermission('Flight Manager')) { ?>
	<th><?php echo order_link('f.price_instructor', "index.php", 'Instruktoriui') ?></th>
<?php   } ?>
	<th><?php echo order_link('f.comments', "index.php", 'Komentarai') ?></th>
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
	  <?php echo theme('display', 'amount_time', NULL, $flight, array('amount_time' => $flight->amount . (!empty($flight->duration) ? (' / ' . DateHelper::time_as_string(floatval($flight->duration))) : NULL))) ?>
	</td>
	<td>
	  <?php echo theme('display_money', 'price', NULL, $flight) ?>
	</td>
<?php   if ($this->HasPermission('Flight Manager')) { ?>
	<td>
<?php     if (!empty($flight->price_instructor)) { ?>
	  <?php echo theme('display_money', 'price_instructor', NULL, $flight) ?>
<?php     } ?>
	</td>
<?php   } ?>
	<td>
	  <?php echo theme('display', 'comments', NULL, $flight) ?>
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
<?php   if ($this->HasPermission('Flight Manager') || ($flight->payer == UserHelper::get_id())) { ?>
    <tfoot>
<?php
$amount = 0;
$duration = 0.0;
$price = 0.0;
$price_instructor = 0.0;
foreach ( $results['flights']['results'] as $flight) {
  $amount += $flight->amount;
  $duration += floatval($flight->duration);
  $price += $flight->price;
  $price_instructor += $flight->price_instructor;
}
?>
      <tr>
	<td style="width:90px;"></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td><?php echo theme('display', 'amount_time', NULL, NULL, array('amount_time' => $amount . (!empty($duration) ? (' / ' . DateHelper::time_as_string(floatval($duration))) : NULL))) ?></td>
	<td><?php echo theme('display_money', 'price', NULL, NULL, array('price' => $price)) ?></td>
<?php   if ($this->HasPermission('Flight Manager')) { ?>
	<td><?php echo theme('display_money', 'price_instructor', NULL, NULL, array('price_instructor' => $price_instructor)) ?></td>
<?php   } ?>
	<td></td>
	<td style="width:60px;"></td>
<?php if ($this->HasPermission()) { ?>
	<td style="width:60px;"></td>
	<td style="width:69px;"></td>
<?php } ?>
      </tr>
    </tfoot>
<?php   } ?>
  </table>
<?php   if ($this->HasPermission('Flight Manager')) { ?>
  <br />
  <a class="btn btn-sm btn-primary" href="index.php?action=flight&amp;view=NewItem&amp;date=<?php echo !empty($_GET['date_to']) ? $_GET['date_to'] : NULL ?>">Pridėti naują skrydį</a>
  <a class="btn btn-sm btn-default" href="index.php?action=flight&amp;view=Download&amp;date=<?php echo !empty($_GET['date_to']) ? $_GET['date_to'] : NULL ?>">Parsisiųsti</a>
<?php   } ?>
</div>
