<?php
require_once dirname(__FILE__) . '/../../models/user.inc';
$data = User::getList();
$users = array();
foreach ($data['results'] as $user)
  $users[$user->id] = $user;
require_once dirname(__FILE__) . '/../../models/service.inc';
$data = Service::getList();
$services = array();
foreach ($data['results'] as $service)
  $services[$service->id] = $service;
require_once dirname(__FILE__) . '/../../models/aircraft.inc';
$data = Aircraft::getList();
$airplanes = array();
foreach ($data['results'] as $airplane)
  $airplanes[$airplane->id] = $airplane;
?>

<div class="page-header"><h1>Skrydžiai</h1></div>
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
<?php if ($this->HasPermission()) { ?>
	<th style="width:60px;"></th>
	<th style="width:69px;"></th>
<?php } ?>
      </tr>
    </thead>
	<tbody>
<?php foreach ( $results['flights'] as $flight) { ?>


      <tr>
	<td>
	  <a href="admin.php?action=flight&amp;view=View&amp;id=<?php echo $flight->record_id ?>"><?php echo $flight->record_id ?></a>
	</td>
	<td>
	  <?php echo theme('display', 'date', NULL, $flight) ?>
	</td>
	<td>
	  <?php echo !empty($airplanes[$flight->airplane_id]) ? $airplanes[$flight->airplane_id]->name : NULL ?>
	</td>
	<td>
	  <?php echo !empty($services[$flight->service_id]) ? $services[$flight->service_id]->title : NULL ?>
	</td>
	<td>
	  <?php echo !empty($users[$flight->payer]) ? $users[$flight->payer]->name : NULL ?>
	</td>
	<td>
	  <?php echo !empty($users[$flight->instructor]) ? $users[$flight->instructor]->name : NULL ?>
	</td>
	<td>
	  <?php echo theme('display', 'amount', NULL, $flight) ?>
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
</div>
